# Overview
A MarkDown editor for Adminer/Adminer Editor. I created this so I can more easily edit my blog posts in Adminer Editor, but it might be more generally useful.

## How does it look?
![This is why](http://i.imgur.com/RW6JO5i.png)

# Usage
- Place the things here relative to your adminer file.
- Load `plugins/plugins/adminer-md-editor.php` in your loader file.
- Update your loader with the `AdminerEditMarkdown` plugin. 
- Edit `plugins/adminer-md-editor.php` and change `$markdownFields = array('PostData');` to a list of your markdown field names.

# License
Do whatever you like. MIT License or whatever.

This is based on [markdown-editor by jbt](https://github.com/jbt/markdown-editor)