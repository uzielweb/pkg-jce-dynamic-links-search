<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Search.Dynamic
 *
 * @copyright   Copyright (C) 2025 Ponto Mega. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Database\ParameterType;

/**
 * Dynamic Search plugin
 * Creates search areas based on JCE Links Dynamic plugin configurations
 */
class PlgSearchDynamic extends CMSPlugin
{
    protected $autoloadLanguage = true;

    /**
     * Load JCE adapter if JCE is requesting
     */
    public function __construct(&$subject, $config = array())
    {
        parent::__construct($subject, $config);
    }

    /**
     * Get configurations from JCE Links Dynamic plugin
     *
     * @return  array  Array of configurations
     */
    private function getDynamicConfigs()
    {
        // Try to get the JCE Links Dynamic plugin
        $plugin = PluginHelper::getPlugin('jce', 'links_dynamic');
        
        if (!$plugin) {
            return array();
        }
        
        $params = new \Joomla\Registry\Registry($plugin->params);
        $configs = $params->get('link_configs', array());
        
        return is_array($configs) ? $configs : array();
    }

    /**
     * Content Search Areas
     *
     * @return  array  An array of search areas
     */
    public function onContentSearchAreas()
    {
        $areas = array();
        $configs = $this->getDynamicConfigs();
        
        if (empty($configs)) {
            return $areas;
        }
        
        foreach ($configs as $index => $config) {
            if (!empty($config->component) && !empty($config->label)) {
                // Create a unique area key based on component and table
                $areaKey = !empty($config->table) ? $config->table : 'dynamic_' . $index;
                $areas[$areaKey] = $config->label;
            }
        }
        
        return $areas;
    }

    /**
     * Search content (dynamic)
     *
     * @param   string  $text      Target search string
     * @param   string  $phrase    Matching option (exact|any|all)
     * @param   string  $ordering  Ordering option (newest|oldest|popular|alpha|category)
     * @param   mixed   $areas     An array if the search is to be restricted to areas or null to search all areas
     *
     * @return  array  Search results
     */
    public function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
    {
        $db = Factory::getDbo();
        $app = Factory::getApplication();
        $user = $app->getIdentity();

        // Get our search areas
        $searchAreas = $this->onContentSearchAreas();
        
        // Check if we should search in this plugin
        if (is_array($areas) && !array_intersect($areas, array_keys($searchAreas))) {
            return array();
        }

        $limit = $this->params->def('search_limit', 50);
        $text = trim($text);
        
        if ($text == '') {
            return array();
        }

        $rows = array();
        $configs = $this->getDynamicConfigs();
        
        if (empty($configs)) {
            return array();
        }

        // Loop through each configuration
        foreach ($configs as $index => $config) {
            if (empty($config->component) || empty($config->table)) {
                continue;
            }

            // Check if this area is being searched
            $areaKey = !empty($config->table) ? $config->table : 'dynamic_' . $index;
            if (is_array($areas) && !in_array($areaKey, $areas)) {
                continue;
            }

            $results = $this->searchConfig($config, $text, $phrase, $ordering, $limit);
            $rows = array_merge($rows, $results);
        }

        return $rows;
    }

    /**
     * Search in a specific configuration
     *
     * @param   object  $config    Configuration object
     * @param   string  $text      Search text
     * @param   string  $phrase    Phrase matching
     * @param   string  $ordering  Ordering
     * @param   int     $limit     Result limit
     *
     * @return  array  Search results
     */
    private function searchConfig($config, $text, $phrase, $ordering, $limit)
    {
        $db = Factory::getDbo();
        $rows = array();
        
        try {
            $query = $db->getQuery(true);
            
            // Get field names
            $idField = !empty($config->id_field) ? $config->id_field : 'id';
            $titleField = !empty($config->title_field) ? $config->title_field : 'title';
            $table = $config->table;
            
            // Add prefix if not present
            if (strpos($table, '#__') !== 0) {
                $table = '#__' . $table;
            }
            
            // Additional fields for search
            $displayFields = array();
            if (!empty($config->display_fields)) {
                $displayFields = explode(',', $config->display_fields);
                $displayFields = array_map('trim', $displayFields);
            }
            
            // Build SELECT
            $selectFields = array('a.' . $db->quoteName($idField), 'a.' . $db->quoteName($titleField));
            foreach ($displayFields as $field) {
                if (!empty($field)) {
                    $selectFields[] = 'a.' . $db->quoteName($field);
                }
            }
            
            // Add created/modified fields if they exist (for ordering)
            $dateFields = array('created', 'created_at', 'modified', 'modified_at', 'publish_up');
            foreach ($dateFields as $dateField) {
                if (!in_array('a.' . $db->quoteName($dateField), $selectFields)) {
                    // Try to add it (will fail silently if doesn't exist)
                    $selectFields[] = 'a.' . $db->quoteName($dateField);
                }
            }
            
            $query->select($selectFields)
                ->from($db->quoteName($table) . ' AS a');
            
            // Add state filter if configured
            if (!empty($config->state_field)) {
                $stateField = $config->state_field;
                $stateValue = !empty($config->state_value) ? $config->state_value : 1;
                $query->where('a.' . $db->quoteName($stateField) . ' = ' . $db->quote($stateValue));
            }
            
            // Build search conditions
            $searchFields = array('a.' . $db->quoteName($titleField));
            foreach ($displayFields as $field) {
                if (!empty($field)) {
                    $searchFields[] = 'a.' . $db->quoteName($field);
                }
            }
            
            switch ($phrase) {
                case 'exact':
                    $where = array();
                    foreach ($searchFields as $field) {
                        $where[] = $field . ' LIKE ' . $db->quote('%' . $db->escape($text, true) . '%', false);
                    }
                    $query->where('(' . implode(' OR ', $where) . ')');
                    break;

                case 'all':
                case 'any':
                default:
                    $words = explode(' ', $text);
                    $where = array();
                    foreach ($words as $word) {
                        $word = $db->escape($word, true);
                        $wordWhere = array();
                        foreach ($searchFields as $field) {
                            $wordWhere[] = $field . ' LIKE ' . $db->quote('%' . $word . '%', false);
                        }
                        $where[] = '(' . implode(' OR ', $wordWhere) . ')';
                    }
                    
                    if ($phrase == 'all') {
                        $query->where(implode(' AND ', $where));
                    } else {
                        $query->where(implode(' OR ', $where));
                    }
                    break;
            }
            
            // Ordering
            $orderField = !empty($config->order_field) ? $config->order_field : $titleField;
            
            switch ($ordering) {
                case 'alpha':
                    $query->order('a.' . $db->quoteName($titleField) . ' ASC');
                    break;

                case 'oldest':
                    // Try to order by date fields
                    $query->order('a.' . $db->quoteName($orderField) . ' ASC');
                    break;

                case 'popular':
                case 'newest':
                default:
                    $query->order('a.' . $db->quoteName($orderField) . ' DESC');
                    break;
            }
            
            $db->setQuery($query, 0, $limit);
            $items = $db->loadObjectList();
            
            // Build result rows
            $section = !empty($config->label) ? $config->label : $table;
            $component = !empty($config->component) ? $config->component : '';
            $viewName = !empty($config->view_name) ? $config->view_name : 'item';
            $idParam = !empty($config->id_param) ? $config->id_param : 'id';
            
            foreach ($items as $item) {
                $itemId = $item->$idField;
                $titleValue = $item->$titleField;
                
                // Build display title with extra fields
                $displayTitle = $titleValue;
                if (!empty($displayFields)) {
                    $extras = array();
                    foreach ($displayFields as $field) {
                        if (!empty($field) && isset($item->$field) && !empty($item->$field)) {
                            $extras[] = $item->$field;
                        }
                    }
                    if (!empty($extras)) {
                        $displayTitle .= ' (' . implode(', ', $extras) . ')';
                    }
                }
                
                // Get description/text if available
                $description = '';
                $descFields = array('description', 'introtext', 'descricao', 'descricao_perfil', 'intro', 'text');
                foreach ($descFields as $descField) {
                    if (isset($item->$descField) && !empty($item->$descField)) {
                        $description = strip_tags($item->$descField);
                        break;
                    }
                }
                
                // Get created date if available
                $created = '';
                foreach ($dateFields as $dateField) {
                    if (isset($item->$dateField) && !empty($item->$dateField)) {
                        $created = $item->$dateField;
                        break;
                    }
                }
                
                $rows[] = (object) array(
                    'title'      => $displayTitle,
                    'text'       => $description,
                    'section'    => $section,
                    'created'    => $created,
                    'href'       => 'index.php?option=' . $component . '&view=' . $viewName . '&' . $idParam . '=' . $itemId,
                    'browsernav' => 2
                );
            }
            
        } catch (Exception $e) {
            // Log error but continue with other configs
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
        }
        
        return $rows;
    }
}
