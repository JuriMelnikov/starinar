function ajaxSelect(id) {
    var element = document.getElementById(id)

    var onLoaded = function(data) {
        var i=0
        for(var key in data) {
            var label = data[key]
            element.options[i++] = new Option(label, key)
        }
    }
    
    var onLoadError = function(error) {
        var msg = "������ "+error.errcode
        if (error.message) msg = msg + ' :'+error.message
        alert(msg)
    }
    
    var showLoading = function(on) {
        element.disabled = on
    }

    var onSuccess = function(data) {
        if (!data.errcode) {
            onLoaded(data)
            showLoading(false)        
        } else {
            showLoading(false)
            onLoadError(data)            
        }
    }
    
    
    var onAjaxError = function(xhr, status){
        showLoading(false)
        var errinfo = { errcode: status }
        if (xhr.status != 200) {
            // ����� ���� ������ 200, � ������
            // ��-�� ������������� JSON
            errinfo.message = xhr.statusText
        } else {
            errinfo.message = '������������ ������ � �������'
        }
        onLoadError(errinfo)
    }

    
    return {
        load: function(url) {
            showLoading(true)

            while (element.firstChild) {
                element.removeChild(element.firstChild)
            }

            $.ajax({ // ��� ��������� - jQuery
                url: url,
                dataType: "json",
                success: onSuccess,
                error: onAjaxError,
                cache: false
            })
        }
    }
}
