# Dynamic Search Plugin for Joomla

This Joomla search plugin automatically creates search areas based on the configurations from the **JCE Links Dynamic** plugin. It provides dynamic, multi-table search functionality across any components and tables configured in JCE Links Dynamic.

## Features

- **Automatic Search Areas**: Automatically creates search areas based on JCE Links Dynamic configurations
- **Multi-Table Support**: Search across multiple tables and components simultaneously
- **Dynamic Configuration**: No need to hard-code table names or fields
- **Flexible Search**: Searches across title fields and additional display fields
- **JCE Integration**: Fully integrated with JCE Editor's Link Browser
- **Configurable Limits**: Set maximum results per search area

## Installation

1. Install via Joomla Extensions installer or Discovery
2. Enable the plugin in **Extensions → Plugins**
3. Ensure **JCE Links Dynamic** plugin is installed and configured
4. In JCE Editor settings (**Components → JCE Editor → Profiles**), go to the **Link** tab
5. The search areas will appear automatically based on your JCE Links Dynamic configurations

## How It Works

The plugin reads the configurations from the **JCE Links Dynamic** plugin and:

1. Creates a search area for each configuration
2. Uses the configured table, fields, and filters
3. Searches across the title field and additional display fields
4. Returns results formatted with the component's URL structure

### Example

If you have JCE Links Dynamic configured with:
- **Advogados** (table: advogados, title: nome, fields: linguagem)
- **Artigos** (table: content, title: title, fields: language, catid)

This plugin will automatically create two search areas:
- **Advogados** - searches in advogados table
- **Artigos** - searches in content table

## Configuration

- **Search Limit**: Maximum number of search results per area (default: 50)

## Usage

### Via Link Browser Search
1. Open JCE editor
2. Click the **Link** button  
3. In the search field at top, select the desired area from dropdown
4. Type your search term and click search
5. Click a result to insert the link

### Via Joomla Search
The plugin also integrates with Joomla's standard search component, making all configured areas searchable site-wide.

## Requirements

- Joomla 4.x or 5.x
- PHP 7.4 or higher
- **JCE Links Dynamic** plugin installed and configured
- JCE Editor

## Technical Details

- **Type**: Search Plugin (Joomla standard)
- **Group**: search
- **Events**: `onContentSearchAreas`, `onContentSearch`
- **Dependencies**: JCE Links Dynamic plugin

## Changelog

### 1.0.0 - Initial Release
- Dynamic search area creation based on JCE Links Dynamic configurations
- Multi-table search support
- Automatic field detection and searching
- JCE Link Browser integration

## License

GNU General Public License version 2 or later

## Author

**Ponto Mega**
- Website: www.pontomega.com.br

## Credits

Based on the original Search Advogados plugin, now fully dynamic and extensible.
- **Database**: `#__advogados` table
- **JCE Compatible**: Yes (automatically detected)
- **JCE Link Browser**: Requires file in JCE core (auto-installed by script.php)

## Why This Approach?

As confirmed by JCE developer Ryan Demmer ([GitHub Issue #140](https://github.com/widgetfactory/jce/issues/140)):

1. **Search functionality**: JCE natively supports Joomla Search plugins
2. **Link browser navigation**: Requires a file in JCE's joomlalinks folder (no plugin API available)

This plugin uses both methods:
- Search plugin for the search functionality (standard Joomla way)
- Installation script to copy link browser file to JCE core (only way to add folder navigation)

## File Locations

After installation:
- Plugin files: `plugins/search/advogados/`
- JCE adapter (auto-copied): `components/com_jce/editor/extensions/links/joomlalinks/advogados.php`

## Uninstallation

The plugin will automatically:
- Remove itself from `plugins/search/advogados/`
- Delete the JCE adapter file
- Clean up all references

## License

GNU General Public License version 2 or later
