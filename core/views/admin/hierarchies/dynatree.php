<?php if (!defined('DYNATREE')) { } else { define('DYNATREE', TRUE); } ?>
<script type="text/javascript">
$(document).ready(function() {
	$("#<?php echo $tree_id; ?>").dynatree({
    	onActivate: function(node) {
      	},
      	debugLevel : 0,
      	minExpandLevel : 3,
      	checkbox: true,
        selectMode: <?php echo $tree_mode; ?>,
      	children: <?php echo json_encode($tree); ?>
    });

	$("form<?php echo $tree_form; ?>").submit(function() {

	    // then append Dynatree selected 'checkboxes':
	    var tree = $("#<?php echo $tree_id; ?>").dynatree("getTree");
		
		if (tree) {
			 
			var nodeList = tree.getSelectedNodes(), arr = [];
			for(var i=0, l=nodeList.length; i<l; i++){
				//arr.push(nodeList[i].data.key);
				$("form<?php echo $tree_form; ?>")
					.append('<input type="checkbox" class="hidden" checked="checked" name="<?php echo $tree_input; ?>[]" value="'+nodeList[i].data.key+'" />');
			}
		}

		fastcms.add_form_hash();
	    return true;
	});
});
</script>