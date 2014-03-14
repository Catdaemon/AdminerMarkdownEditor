<?php

class AdminerEditMarkdown {
	var $prepend;

	function AdminerEditMarkdown() {
		$this->prepend = '
			<script src="md-editor/marked.js"></script>
			<script src="md-editor/highlight.pack.js"></script>
			<script src="md-editor/codemirror/lib/codemirror.js"></script>
			<script src="md-editor/codemirror/xml/xml.js"></script>
			<script src="md-editor/codemirror/markdown/markdown.js"></script>
			<script src="md-editor/codemirror/gfm/gfm.js"></script>
			<script src="md-editor/codemirror/javascript/javascript.js"></script>
			<script src="md-editor/rawinflate.js"></script>
			<script src="md-editor/rawdeflate.js"></script>
			<script src="md-editor/adminer.md.js"></script>
			<link rel="stylesheet" href="md-editor/codemirror/lib/codemirror.css">
			<link rel="stylesheet" href="md-editor/default.css">';
	}

	function head() {
		echo $this->prepend;
	}

	function editInput($table, $field, $attrs, $value) {
		// Fields names for markdown editing.
		$markdownFields = array('PostData');

		if (in_array($field['field'], $markdownFields) )
		{
			return "
				<div>
					<textarea id='mdeditor' id='fields-" . h($field["field"]) . "'" . (+$field["length"] ? " maxlength='" . (+$field["length"]) . "'" : "") . "$attrs>" . h($value) . "</textarea>
					<div id='mdout' style='float:right;width:53%;'>
				</div>
				<script>initMD();</script>
			";
		}
	}

}