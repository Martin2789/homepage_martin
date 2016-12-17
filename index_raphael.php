<div id="editor" class="widget" style="height:260px;"></div>
<input type="hidden" id="data2" name="data2" />

<div class="clear widget_actions span-2">
	<div class="_title">Color</div>
	<div id="editor_black" class="selected">Black</div>
	<div id="editor_red">Red</div>
</div>
<div class="widget_actions span-2">
	<div class="_title">Width</div>
	<div id="editor_thin" class="selected">Thin</div>
	<div id="editor_thick">Thick</div>
</div>
<div class="widget_actions span-2">
	<div class="_title">Opacity</div>
	<div id="editor_solid" class="selected">Solid</div>
	<div id="editor_fuzzy">Fuzzy</div>
</div>
<div class="widget_actions span-2 last">
	<div id="editor_undo" class="disabled">Undo</div>
	<div id="editor_redo" class="disabled">Redo</div>
	<div id="editor_clear" class="disabled">Clear</div>
</div>
<div class="clear"></div>
<div class="widget_actions span-4">
	<div id="editor_draw_erase">Draw</div>
</div>
<div class="widget_actions span-4 last">
	<div id="editor_animate">Animate!</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var sketchpad = Raphael.sketchpad("editor", {
			height: 260,
			width: 260,
			editing: true	// true is default
		});

		// When the sketchpad changes, update the input field.
		sketchpad.change(function() {
			$("#data2").val(sketchpad.json());
		});

		sketchpad.strokes([{
			"type":"path",
			"path":[["M",10,10],["L",90,90]],
			"fill":"none",
			"stroke":"#000000",
			"stroke-opacity":1,
			"stroke-width":5,
			"stroke-linecap":"round",
			"stroke-linejoin":"round"
		}]);

		function enable(element, enable) {
			if (enable) {
				$(element).removeClass("disabled");
			} else {
				$(element).addClass("disabled");
			}
		};

		function select(element1, element2) {
			$(element1).addClass("selected");
			$(element2).removeClass("selected");
		}

		$("#editor_undo").click(function() {
			sketchpad.undo();
		});
		$("#editor_redo").click(function() {
			sketchpad.redo();
		});
		$("#editor_clear").click(function() {
			sketchpad.clear();
		});
		$("#editor_animate").click(function() {
			sketchpad.animate();
		});

		$("#editor_thin").click(function() {
			select("#editor_thin", "#editor_thick");
			sketchpad.pen().width(5);
		});
		$("#editor_thick").click(function() {
			select("#editor_thick", "#editor_thin");
			sketchpad.pen().width(15);
		});
		$("#editor_solid").click(function() {
			select("#editor_solid", "#editor_fuzzy");
			sketchpad.pen().opacity(1);
		});
		$("#editor_fuzzy").click(function() {
			select("#editor_fuzzy", "#editor_solid");
			sketchpad.pen().opacity(0.3);
		});
		$("#editor_black").click(function() {
			select("#editor_black", "#editor_red");
			sketchpad.pen().color("#000");
		});
		$("#editor_red").click(function() {
			select("#editor_red", "#editor_black");
			sketchpad.pen().color("#f00");
		});
		$("#editor_draw_erase").toggle(function() {
			$(this).text("Erase");
			sketchpad.editing("erase");
		}, function() {
			$(this).text("Draw");
			sketchpad.editing(true);
		});

		function update_actions() {
			enable("#editor_undo", sketchpad.undoable());
			enable("#editor_redo", sketchpad.redoable());
			enable("#editor_clear", sketchpad.strokes().length > 0);
		}

		sketchpad.change(update_actions);

		update_actions();
	});
</script>