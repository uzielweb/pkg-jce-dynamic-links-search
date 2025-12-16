# JCE Dynamic Links & Search - Complete Package

[![Joomla](https://img.shields.io/badge/Joomla-4.x%20%7C%205.x-blue.svg)](https://www.joomla.org)
[![License](https://img.shields.io/badge/license-GPL--2.0-green.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-1.0.0-orange.svg)](https://github.com/uzielweb/pkg-jce-dynamic-links-search/releases)

Complete solution for dynamic link browsing and searching in Joomla's JCE Editor. Create links and search across any database tables and components with a single, flexible configuration.

## 📦 What's Included

This package includes two powerful plugins that work together:

### 1. **JCE Links Dynamic** (plg_jce_links_dynamic)
Plugin for JCE Editor that creates dynamic link categories in the Link Browser.

**Features:**
- Configure any database table as a link source
- Multiple link categories from a single plugin
- Customizable field mapping (ID, title, display fields)
- State filtering and custom ordering
- Search functionality within each category

### 2. **Search Dynamic** (plg_search_dynamic)
Search plugin that automatically creates search areas based on JCE Links Dynamic configurations.

**Features:**
- Automatic search area creation
- Multi-table search support
- Integrated with JCE Link Browser
- Works with Joomla's standard search
- Zero additional configuration needed

## 🚀 Quick Start

### Installation

1. Download the latest release ZIP file
2. In Joomla admin, go to **System → Extensions → Install**
3. Upload the package ZIP file
4. The package will install both plugins automatically

### Configuration

1. Go to **Extensions → Plugins**
2. Enable **JCE - Links Dynamic** plugin
3. Click on the plugin name to configure
4. Add your link configurations (see example below)
5. Enable **Search - Dynamic** plugin
6. Done! Search areas are created automatically

### Example Configuration

In JCE Links Dynamic plugin, add a configuration:

```
Label: Lawyers
Component: com_advogados
Table: advogados
ID Field: id
Title Field: nome
Display Fields: linguagem, cargo
State Field: state
State Value: 1
Order Field: nome
Order Direction: ASC
View Name: advogado
ID Parameter: id
```

This creates:
- ✅ A "Lawyers" category in JCE Link Browser
- ✅ A "Lawyers" search area in JCE and Joomla search
- ✅ Links to `index.php?option=com_advogados&view=advogado&id=X`

## 📋 Requirements

- Joomla 4.x or 5.x
- PHP 7.4 or higher
- JCE Editor installed and enabled

## 🎯 Use Cases

Perfect for:

- **Multi-component sites**: Link to custom components easily
- **E-commerce**: Link to products, categories, brands
- **Directories**: Lawyers, doctors, members, companies
- **Custom tables**: Any database table can be a link source
- **Multilingual sites**: Show language in results
- **Corporate sites**: Link to departments, services, locations

## 📖 Documentation

### JCE Links Dynamic Plugin

See [plg_jce_links_dynamic/README.md](plg_jce_links_dynamic/README.md) for:
- Detailed configuration options
- Field descriptions
- Multiple examples
- Advanced usage

### Search Dynamic Plugin

See [plg_search_dynamic/README.md](plg_search_dynamic/README.md) for:
- How it works
- Integration details
- Technical information

## 🔧 Configuration Fields

| Field | Description | Example |
|-------|-------------|---------|
| **Label** | Display name in JCE | "Articles", "Products" |
| **Component** | Joomla component name | com_content, com_shop |
| **Table** | Database table (no #__) | content, products |
| **ID Field** | Primary key column | id |
| **Title Field** | Display title column | title, name, nome |
| **Display Fields** | Extra info (comma-separated) | language, category |
| **State Field** | Publication status column | state, published |
| **State Value** | Value for published items | 1 |
| **Order Field** | Sort by this column | title, ordering |
| **Order Direction** | ASC or DESC | ASC |
| **View Name** | Component view name | article, product |
| **ID Parameter** | URL parameter name | id, item_id |

## 📝 Changelog

### Version 1.0.0 - December 2025

**Initial Release**
- JCE Links Dynamic plugin v1.0.3
- Search Dynamic plugin v1.0.0
- Complete package integration
- Multi-language support (pt-BR, en-GB)
- Update server configuration

## 🐛 Support & Issues

If you encounter any problems:

1. Check the [documentation](https://github.com/uzielweb/pkg-jce-dynamic-links-search/wiki)
2. Search [existing issues](https://github.com/uzielweb/pkg-jce-dynamic-links-search/issues)
3. [Create a new issue](https://github.com/uzielweb/pkg-jce-dynamic-links-search/issues/new) if needed

## 👨‍💻 Author

**Ponto Mega**
- GitHub: [@uzielweb](https://github.com/uzielweb)
- Website: www.pontomega.com.br

## 📄 License

This project is licensed under the GNU/GPL v2.0 or later - see the [LICENSE](LICENSE) file for details.

## 🙏 Credits

- Joomla Community
- JCE Editor Team
- All contributors

## 🌟 Show Your Support

If this package helps your project, please:
- ⭐ Star the repository
- 🐛 Report bugs
- 💡 Suggest features
- 📢 Share with others

---

**Made with ❤️ by Ponto Mega**
