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
<link rel="stylesheet" href="md-editor/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="md-editor/default.css">
<script>

function initMD()
{
    var URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
    navigator.saveBlob = navigator.saveBlob || navigator.msSaveBlob || navigator.mozSaveBlob || navigator.webkitSaveBlob;
    window.saveAs = window.saveAs || window.webkitSaveAs || window.mozSaveAs || window.msSaveAs;

    // Because highlight.js is a bit awkward at times
    var languageOverrides = {
      js: "javascript",
      html: "xml"
    }

    marked.setOptions({
      highlight: function(code, lang){
        if(languageOverrides[lang]) lang = languageOverrides[lang];
        return hljs.LANGUAGES[lang] ? hljs.highlight(lang, code).value : code;
      }
    });

    function update(e){
      var val = e.getValue();

      setOutput(val);

      clearTimeout(hashto);
      hashto = setTimeout(updateHash, 1000);
    }

    function setOutput(val){
      val = val.replace(/<equation>((.*?\n)*?.*?)<\/equation>/ig, function(a, b){
        return \'<img src="http://latex.codecogs.com/png.latex?\' + encodeURIComponent(b) + \'" />\';
      });

      document.getElementById(\'mdout\').innerHTML = marked(val);
    }

    var editor = CodeMirror.fromTextArea(document.getElementById("mdeditor"), {
      mode: "gfm",
      lineNumbers: false,
      matchBrackets: true,
      lineWrapping: true,
      theme: "default",
      viewportMargin: Infinity,
      onChange: update
    });

    document.addEventListener(\'drop\', function(e){
      e.preventDefault();
      e.stopPropagation();

      var theFile = e.dataTransfer.files[0];
      var theReader = new FileReader();
      theReader.onload = function(e){
        editor.setValue(e.target.result);
      };

      theReader.readAsText(theFile);
    }, false);

    function save(){
      var code = editor.getValue();
      var blob = new Blob([code], { type: \'text/plain\' });
      saveBlob(blob);
    }

    function saveBlob(blob){
      var name = "untitled.md";
      if(window.saveAs){
        window.saveAs(blob, name);
      }else if(navigator.saveBlob){
        navigator.saveBlob(blob, name);
      }else{
        url = URL.createObjectURL(blob);
        var link = document.createElement("a");
        link.setAttribute("href",url);
        link.setAttribute("download",name);
        var event = document.createEvent(\'MouseEvents\');
        event.initMouseEvent(\'click\', true, true, window, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
        link.dispatchEvent(event);
      }
    }

    document.addEventListener(\'keydown\', function(e){
      if(e.keyCode == 83 && (e.ctrlKey || e.metaKey)){
        e.preventDefault();
        save();
        return false;
      }
    })

    var hashto;

    function updateHash(){
      window.location.hash = btoa(RawDeflate.deflate(unescape(encodeURIComponent(editor.getValue()))))
    }

    if(window.location.hash){
      var h = window.location.hash.replace(/^#/, \'\');
      if(h.slice(0,5) == \'view:\'){
        setOutput(decodeURIComponent(escape(RawDeflate.inflate(atob(h.slice(5))))));
        document.body.className = \'view\';
      }else{
        editor.setValue(decodeURIComponent(escape(RawDeflate.inflate(atob(h)))))
        update(editor);
        editor.focus();
      }
    }else{
      update(editor);
      editor.focus();
    }
}
</script>';
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
			<script>initMD();</script>";
		}
	}

}