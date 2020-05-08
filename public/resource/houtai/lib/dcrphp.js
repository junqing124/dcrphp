function showError(result){
    let response = $.parseJSON(result.responseText);
    let msg = response.error.message + ',file:' + response.error.file + ',line:' + response.error.line;
    layer.alert(msg, {icon: 2});
}
function showFailed(result){
    layer.alert('操作失败:' + result.msg, {icon: 2});
}
function showSuccess(result){
    layer.msg('操作成功', {icon: 1, time: 1500});
}

/**
 * ajax提交数据，这个function的主要目的和初衷是统一展示成功失败或错误的信息
 * @param url 必填
 * @param data 必填
 * @param method 默认是post
 * @param success_callback 成功调用的function
 * @param failed_callback 失败调用的function
 * @param error_callback 错误调用的function
 */
function ajax(url, data, method, success_callback, failed_callback, error_callback) {

    if (method == null || method == '') {
        method = 'POST';
    }
    if (success_callback == null) {
        success_callback = function (result) {
            showSuccess(result);
        }
    }
    if (failed_callback == null) {
        failed_callback = function (result) {
            showFailed(result);
        }
    }
    if (error_callback == null) {
        error_callback = function (result) {
            showError(result);
        }
    }
    $.ajax({
        type: method,
        url: url,
        dataType: 'json',
        data: data,
        success: function (result) {
            if (result.ack) {
                success_callback(result);
            } else {
                failed_callback(result);
            }
        },
        error: function (result) {
            error_callback(result);
        },
    });
}

/**
 * 本function用来弹出指定url的窗体 仿layer_show方法 layer_show不能用百分比 所有有这个
 * @param title 标题
 * @param url 地址
 * @param width 宽
 * @param height 高
 */
function open_iframe(title, url, width, height) {
    if (title == null || title == '') {
        title = false;
    }
    if (url == null || url == '') {
        url = "404.html";
    }
    if (width == null || width == '') {
        width = '800px';
    }
    if (height == null || height == '') {
        height = ($(window).height() - 50) + 'px';
    }
    let w_r1 = width.substring(width.length - 1); //宽的最后一位
    let h_r1 = height.substring(height.length - 1); //宽的最后一位
    if (w_r1 != 'x' && w_r1 != '%') {
        width = width + 'px';
    }
    if (h_r1 != 'x' && h_r1 != '%') {
        height = height + 'px';
    }
    let index = layer.open({
        type: 2,
        title: title,
        content: url,
        area: [width, height]
    });
}