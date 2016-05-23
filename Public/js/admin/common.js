/**
 * Created by guojingfeng on 2016/5/19.
 */
//添加菜单操作
$('#button-add').click(function(){
    var url = SCOPE.add_url;
    window.location.href = url;
});
$('#singcms-button-submit').click(function () {
    var data = $('#singcms-form').serializeArray();
    postData = {};
    $(data).each(function (i) {
        postData[this.name] = this.value;
    });
    url = SCOPE.save_url;
    jump_url = SCOPE.jump_url;
    $.post(url,postData,function (result) {
        if(result.status == 1){
            //成功
            return dialog.success(result.message,jump_url);
        }else if(result.status == 0){
            //失败
            return dialog.error(result.message);
        }
    },'JSON');
});
//编辑菜单操作
$('.singcms-edit').on('click',function () {
    var url = SCOPE.edit_url;
    var attr = $(this).attr('attr-id');
    window.location.href = url+'&id='+attr;
});
//删除菜单操作
$('.singcms-delete').on('click',function () {
    var id = $(this).attr('attr-id');
    var a = $(this).attr('attr-a');
    var msg = $(this).attr('attr-message');
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = -1;
    layer.open({
        type : 0,
        title : "确认提交？",
        btn : ['yes','no'],
        icon : 3,
        closeBtn : 2,
        content : "是否确定" + msg,
        scrollbar : true,
        yes : function () {
            todelete(url,data);
        },
    });
});

function todelete(url,data) {
    $.post(
        url,
        data,
        function (s) {
            if(s.status == 1){
                return dialog.success(s.message,'')
            }else{
                return dialog.error(s.message);
            }
        },"JSON"
    )
}
//更新排序操作
$('#button-order').click(function () {
    var data = $('#singcms-listorder').serializeArray();
    console.log(data);
    postData = {};
    $(data).each(function (i) {
        postData[this.name] = this.value;
    });
    console.log(postData);
    url = SCOPE.listorder_url;
    $.post(url,postData,function (result) {
        if(result.status == 1){
            //成功
            return dialog.success(result.message,result['data']['jump_url']);
        }else if(result.status == 0){
            //失败
            return dialog.error(result.message,result['data']['jump_url']);
        }
    },'JSON');
});
//删除文章操作
$('.singcms-delete').on('click',function () {
    var id = $(this).attr('attr-id');
    var msg = $(this).attr('attr-message');
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = -1;
    layer.open({
        type : 0,
        title : "确认提交？",
        btn : ['yes','no'],
        icon : 3,
        closeBtn : 2,
        content : "是否确定" + msg,
        scrollbar : true,
        yes : function () {
            todelete(url,data);
        },
    });
});

function todelete(url,data) {
    $.post(
        url,
        data,
        function (s) {
            if(s.status == 1){
                return dialog.success(s.message,'')
            }else{
                return dialog.error(s.message);
            }
        },"JSON"
    )
}