<?php
/**
 * @version     1.0.4
 * @package     JCE Dynamic Links
 * @author      Ponto Mega
 * @copyright   Copyright (c) 2025 Ponto Mega. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or defined('_WF_EXT') or die('ERROR_403');

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;

class WFLinkBrowser_dynamic extends CMSObject
{
    public $plugin = null;

    public function __construct($config = array())
    {
        parent::__construct();

        $this->setProperties($config);

        // Load language files
        $language = Factory::getLanguage();
        $language->load('plg_jce_links_dynamic', JPATH_ADMINISTRATOR);
    }

    public function getOption()
    {
        $options = array();
        $plugin = PluginHelper::getPlugin('jce', 'links_dynamic');
        
        if ($plugin) {
            $params = new \Joomla\Registry\Registry($plugin->params);
            $configs = $params->get('link_configs', array());
            
            if (!empty($configs)) {
                foreach ($configs as $config) {
                    if (!empty($config->component)) {
                        $options[] = $config->component;
                    }
                }
            }
        }
        
        return array_unique($options);
    }
    
    public function getName()
    {
        return 'dynamic';
    }

    public function getInstance()
    {
        static $instance;

        if (!is_object($instance)) {
            $instance = new WFLinkBrowser_dynamic();
        }
        return $instance;
    }

    public function getList()
    {
        $html = '';
        $plugin = PluginHelper::getPlugin('jce', 'links_dynamic');
        
        if ($plugin) {
            $params = new \Joomla\Registry\Registry($plugin->params);
            $configs = $params->get('link_configs', array());
            
            if (!empty($configs)) {
                foreach ($configs as $config) {
                    if (!empty($config->component) && !empty($config->label)) {
                        $component = $config->component;
                        $label = $config->label;
                        $html .= '<li id="index.php?option=' . htmlspecialchars($component) . '&view=dynamic&config=' . base64_encode(json_encode($config)) . '"><div class="uk-tree-row"><a href="#"><span class="uk-tree-icon folder content nolink"></span><span class="uk-tree-text">' . htmlspecialchars($label) . '</span></a></div></li>';
                    }
                }
            }
        }

        return $html;
    }

    public function display()
    {
        // Load css if needed
        $document = WFDocument::getInstance();
    }

    public function isEnabled()
    {
        return true;
    }

    public function getLinks($args)
    {
        $app = Factory::getApplication();
        $db = Factory::getContainer()->get('DatabaseDriver');

        $items = array();
        $view = isset($args->view) ? $args->view : '';

        if ($view === 'dynamic' && isset($args->config)) {
            // Decodificar configuração
            $configJson = base64_decode($args->config);
            $config = json_decode($configJson);
            
            if (!$config) {
                return $items;
            }

            $search = isset($args->search) ? $args->search : '';
            
            try {
                $query = $db->getQuery(true);
                
                // Campos principais
                $idField = !empty($config->id_field) ? $config->id_field : 'id';
                $titleField = !empty($config->title_field) ? $config->title_field : 'title';
                $table = !empty($config->table) ? $config->table : '';
                
                if (empty($table)) {
                    return $items;
                }
                
                // Adicionar prefixo #__ se não tiver
                if (strpos($table, '#__') !== 0) {
                    $table = '#__' . $table;
                }
                
                // Campos adicionais para exibição
                $displayFields = array();
                if (!empty($config->display_fields)) {
                    $displayFields = explode(',', $config->display_fields);
                    $displayFields = array_map('trim', $displayFields);
                }
                
                // Construir SELECT
                $selectFields = array('a.' . $db->quoteName($idField), 'a.' . $db->quoteName($titleField));
                foreach ($displayFields as $field) {
                    if (!empty($field)) {
                        $selectFields[] = 'a.' . $db->quoteName($field);
                    }
                }
                
                $query->select($selectFields)
                    ->from($db->quoteName($table) . ' AS a');
                
                // Adicionar condição de estado se o campo existir
                if (!empty($config->state_field)) {
                    $stateField = $config->state_field;
                    $stateValue = !empty($config->state_value) ? $config->state_value : 1;
                    $query->where('a.' . $db->quoteName($stateField) . ' = ' . $db->quote($stateValue));
                }
                
                // Adicionar busca
                if (!empty($search)) {
                    $searchConditions = array();
                    $searchConditions[] = 'a.' . $db->quoteName($titleField) . ' LIKE ' . $db->quote('%' . $search . '%');
                    
                    // Buscar também nos campos adicionais
                    foreach ($displayFields as $field) {
                        if (!empty($field)) {
                            $searchConditions[] = 'a.' . $db->quoteName($field) . ' LIKE ' . $db->quote('%' . $search . '%');
                        }
                    }
                    
                    $query->where('(' . implode(' OR ', $searchConditions) . ')');
                }
                
                // Ordenação
                $orderField = !empty($config->order_field) ? $config->order_field : $titleField;
                $orderDir = !empty($config->order_dir) ? $config->order_dir : 'ASC';
                $query->order('a.' . $db->quoteName($orderField) . ' ' . $orderDir);
                
                $db->setQuery($query);
                $results = $db->loadObjectList();
                
                // Processar resultados
                foreach ($results as $item) {
                    // Construir URL
                    $component = !empty($config->component) ? $config->component : '';
                    $viewName = !empty($config->view_name) ? $config->view_name : 'item';
                    $idParam = !empty($config->id_param) ? $config->id_param : 'id';
                    
                    $itemId = $item->$idField;
                    $href = 'index.php?option=' . $component . '&view=' . $viewName . '&' . $idParam . '=' . $itemId;
                    
                    // Construir nome de exibição
                    $titleValue = $item->$titleField;
                    $displayName = $titleValue;
                    
                    // Adicionar campos extras à exibição
                    if (!empty($displayFields)) {
                        $extras = array();
                        foreach ($displayFields as $field) {
                            if (!empty($field) && isset($item->$field) && !empty($item->$field)) {
                                $extras[] = strtoupper($item->$field);
                            }
                        }
                        if (!empty($extras)) {
                            $displayName .= ' (' . implode(', ', $extras) . ')';
                        }
                    }
                    
                    $items[] = array(
                        'id' => $href,
                        'name' => $displayName,
                        'class' => 'file'
                    );
                }
            } catch (Exception $e) {
                // Log erro mas continua
                Factory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
            }
        }

        return $items;
    }
}
