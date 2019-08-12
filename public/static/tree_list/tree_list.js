function con_con(arr){
	var hierarchy=[arr];
	var a=hierarchy_group(hierarchy);
	hierarchy_fetch(a);
	tree_click();
}
//将data分组
function hierarchy_group(arr){
	var len=arr.length;
	var new_arr=[];
	if(len==1){
		new_arr[0]=new Array();
		new_arr[1]=new Array();
		for(var i=0;i<arr[0].length;i++){
			if(arr[0][i].up==0){
				new_arr[0].push(arr[0][i]);
			}else{
				new_arr[1].push(arr[0][i]);
			}
		}
	}else{
		for(var i=0;i<=len;i++){
			new_arr[i]=new Array();
			if(i<len-1){
				for(var j=0;j<arr[i].length;j++){
					new_arr[i].push(arr[i][j]);
				}
			}
		}
		var up_arr=[];
		for(var i=0;i<arr[len-2].length;i++){
			up_arr.push(arr[len-2][i].id);
		}
		for(var i=0;i<arr[len-1].length;i++){
			if(up_arr.indexOf(arr[len-1][i].up)!=-1){
				new_arr[len-1].push(arr[len-1][i]);
			}else{
				new_arr[len].push(arr[len-1][i]);
			}
		}
	}
	if(new_arr[new_arr.length-1].length<1){
		new_arr.pop();
		return new_arr;
	}else{
		return hierarchy_group(new_arr);
	}
}
//渲染页面
function hierarchy_fetch(arr){
	var $tree_ul=$("#tree_list>ul");
	$tree_ul.html('');
	//先显示图像
	for(var k=0;k<arr.length;k++){
		for(var i=0;i<arr[k].length;i++){
			var str='<li><div class="tree_single" tree-id="'+arr[k][i].id+'" tree-node="'+arr[k][i].node+'"><span class="tree_switch"></span><span class="tree_check"></span><div class="tree_title">'+arr[k][i].power_name+'</div></div></li>';
			if(arr[k][i].up==0){
				$tree_ul.append(str);
			}else{
				var $up=$("div[tree-id='"+arr[k][i].up+"']");
				if($up.next("ul").length==0){
					$up.after("<ul class='tree_hide'>"+str+"</ul>");
				}else{
					$up.next("ul").append(str);
				}
			}
		}
	}
	var len=0;
	for(var i=0;i<arr.length;i++){
		len+=arr[i].length;
	}
	var $single=$(".tree_single");
	var $ul=$("#tree_list>ul ul");
	//渲染最左边的图标
	for(var i=0;i<len;i++){	
		if($($single[i]).next("ul").length==0){
			//还得判断后面是否还有内容
			if($($single[i]).closest("li").index()==0){
				if($($single[i].closest("li").closest("ul")).attr("id")=="first"){
					$($single[i]).children(".tree_switch").addClass('tree_node_top');
				}else{
					$($single[i]).children(".tree_switch").addClass('tree_node_middle');
				}
			}else if($($single[i]).closest("li").index()==$($single[i]).closest("li").closest('ul').children("li").length-1){
				$($single[i]).children(".tree_switch").addClass('tree_node_bottom');
			}else{
				$($single[i]).children(".tree_switch").addClass('tree_node_middle');
			}
		}else{
			if($($single[i]).closest("li").index()==0){
				if($($single[i].closest("li").closest("ul")).attr("id")=="first"){
					$($single[i]).children(".tree_switch").addClass('tree_top_off');
				}else{
					$($single[i]).children(".tree_switch").addClass('tree_middle_off');
				}
			}else if($($single[i]).closest("li").index()==$($single[i]).closest("li").closest('ul').children("li").length-1){
				$($single[i]).children(".tree_switch").addClass('tree_bottom_off');
			}else{
				$($single[i]).children(".tree_switch").addClass('tree_middle_off');
			}
		}
	}
	for(var i=0;i<$ul.length;i++){
		if($($ul[i]).closest("li").index()!=$($ul[i]).closest("li").closest('ul').children('li').length-1){
			$($ul[i]).addClass('tree_ul');
		}
	}
	//隐藏
	//选中渲染
	$single.children(".tree_check").addClass('tree_check_no');
}
//点击事件
function tree_click(){
	$(".tree_switch").click(function() {
		if($(this).hasClass("tree_top_off")||$(this).hasClass("tree_middle_off")||$(this).hasClass("tree_bottom_off")){
			if($(this).hasClass("tree_top_off")){
				$(this).removeClass('tree_top_off').addClass('tree_top_on');
			}else if($(this).hasClass("tree_middle_off")){
				$(this).removeClass('tree_middle_off').addClass('tree_middle_on');
			}else if($(this).hasClass('tree_bottom_off')){
				$(this).removeClass('tree_bottom_off').addClass('tree_bottom_on');
			}
			$(this).closest("div").next("ul").slideToggle("show");
		}else if($(this).hasClass("tree_top_on")||$(this).hasClass("tree_middle_on")||$(this).hasClass("tree_bottom_on")){
			if($(this).hasClass("tree_top_on")){
				$(this).removeClass('tree_top_on').addClass('tree_top_off');
			}else if($(this).hasClass("tree_middle_on")){
				$(this).removeClass('tree_middle_on').addClass('tree_middle_off');
			}else if($(this).hasClass('tree_bottom_on')){
				$(this).removeClass('tree_bottom_on').addClass('tree_bottom_off');
			}
			$(this).closest("div").next("ul").slideToggle("show");
		}
	});
	$(".tree_check").click(function() {
		if($(this).hasClass('tree_check_no')){
			$(this).removeClass('tree_check_no').addClass('tree_check_all');
			$(this).closest('div').next('ul').find('.tree_check').removeClass('tree_check_no').removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_all');
			hierarchy_click_check($(this).closest('div').closest('li'));
			$(this).closest('div').closest("li");
		}else if($(this).hasClass('tree_check_all')||$(this).hasClass('tree_check_half')){
			$(this).removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_no');
			$(this).closest('div').next('ul').find('.tree_check').removeClass('tree_check_no').removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_no');
			hierarchy_click_check($(this).closest('div').closest('li'));
		}
	});
}
//上层判断
function hierarchy_click_check(li){
	if(li.closest('ul').attr("id")=="first"){
		return;
	}
	var $ul=li.closest("ul").children('li');
	var arr=[];
	for(var i=0;i<$ul.length;i++){
		if($($ul[i]).children('.tree_single').children('.tree_check').hasClass('tree_check_no')){
			//这里会出现第三种可能
			//详情看样子
			//2下面的3里面只选了一个，2为全选状态
			arr.push("false");
		}else if($($ul[i]).children('.tree_single').children('.tree_check').hasClass('tree_check_all')){
			arr.push("true");
		}else{
			arr.push("par");
		}
	}
	if(arr.indexOf("true")!=-1){//为真
		if(arr.indexOf("false")!=-1||arr.indexOf("par")!=-1){//为假,或者半选
			li.closest('ul').closest('li').children('.tree_single').children('.tree_check').removeClass('tree_check_no').removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_half');
		}else{
			li.closest('ul').closest('li').children('.tree_single').children('.tree_check').removeClass('tree_check_no').removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_all');
		}
	}else{
		if(arr.indexOf("true")!=-1||arr.indexOf("par")!=-1){
			li.closest('ul').closest('li').children('.tree_single').children('.tree_check').removeClass('tree_check_no').removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_half');
		}else{
			li.closest('ul').closest('li').children('.tree_single').children('.tree_check').removeClass('tree_check_no').removeClass('tree_check_all').removeClass('tree_check_half').addClass('tree_check_no');
		}
	}
	hierarchy_click_check(li.closest('ul').closest('li'));
}
//获取选中值
function tree_get(render_data){
	var tree_get_set=$(".tree_check_all").closest('.tree_single');
	var tree_get_id_arr=[];
	var tree_get_node_arr=[];
	for(var i=0;i<tree_get_set.length;i++){
		tree_get_id_arr.push($(tree_get_set[i]).attr("tree-id"));
		tree_get_node_arr.push($(tree_get_set[i]).attr("tree-node"));
		//获取到全部选中的值
	}
	var tree_id_set=[];
	//原效果达成,当子节点全选时只有母节点选中
	// for(var i=0;i<render_data.length;i++){
	// 	if(tree_get_id_arr.indexOf(render_data[i].id)!=-1){
	// 		if(tree_get_id_arr.indexOf(render_data[i].up)==-1){
	// 			tree_id_set.push(render_data[i].id);
	// 		}
	// 	}
	// }

	//只能选中最子节点
	for(var i=tree_get_id_arr.length-1;i>=0;i--){
		for(var j=0;j<render_data.length;j++){
			if(render_data[j].up==tree_get_id_arr[i]){
				break;
			}
			if(j==render_data.length-1){
				tree_id_set.push(tree_get_id_arr[i]);
			}
		}
	}
	return tree_id_set;
}
//渲染数据
function tree_view(data){
	console.log(data);
	for(var i=0;i<data.length;i++){
		console.log(data[i]);
		console.log($("div[tree_id='"+data[i]+"']"));
		$("div[tree-id='"+data[i]+"']").children('.tree_check').trigger("click");
	}
}