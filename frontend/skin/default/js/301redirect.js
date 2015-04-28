var ls=ls || {}

ls.redirect = ls.redirect || {}

ls.redirect.admin = (function ($) {

    this.addItem = function(form) {
	    ls.ajax.submit('/admin/301redirect/ajax/addlink/', form, function(result) {
	        if (result.bStateError) {
                ls.msg.error(null,result.sMsg);
            } else {
                // добавляем в список
                var item = $('<tr/>').addClass('active');
                var checkbox = $('<td/>').addClass('cell-checkbox');
                checkbox.append(
	                $('<input/>').attr('type','checkbox').attr('data-old', $('#old').val()).addClass('form_plugins_checkbox').attr('checked', 'checked').attr('id', 'url_'+result.id));
		        checkbox.append($('<label/>').attr('for', 'url_'+result.id).css({margin:'-2px 0 0 -16px'}));
                item.append(checkbox);
                item.append($('<td/>').attr('width', 370).html($('#old').val()));
                item.append($('<td/>').attr('width', 400).html($('#new').val()));
                var del = $('<td/>');
                del.append($('<a/>').addClass('actions-delete icon-ls-remove').attr('data-old', $('#old').val()).attr('href', '#del').attr('onclick', "return confirm('Вы действительно хотите удалить связь?');"));
                item.append(del);
                if ($('table.redirect tr').size()) {
                    $('table.redirect tr:first-child').before(item);
                } else {
                    $('table.redirect tbody').append(item);
                }

                $('#old, #new').val('');
                ls.redirect.admin.bindDelItem('table.redirect .actions-delete');
                ls.redirect.admin.bindChangeStatus('table.redirect .form_plugins_checkbox');
            }
        }.bind(this));
        return false;
    };

    this.bindChangeStatus = function(className){
        $('.'+className).unbind('click').bind('click', function(){
            var status = $(this).is(':checked');
            ls.redirect.admin.changeStatus($(this).data('old'), status);
            if (status === true) {
                $(this).parents('tr').addClass('active');
            } else {
                $(this).parents('tr').removeClass('active');
            }
        });
    };

    this.bindDelItem = function(className){
        $('.'+className).unbind('click').bind('click', function(){
            ls.redirect.admin.delItem($(this));
            return false;
        });
    };

    this.changeStatus = function(urlOld, status){
        ls.ajax.load('/admin/301redirect/ajax/changestatuslink/', {'link[old]': urlOld, status: status}, function(result) {
            if (result.bStateError) {
                ls.msg.error(null,result.sMsg);
            } else {
                if (result.sMsg) ls.msg.notice(null,result.sMsg);
            }
        }.bind(this));
        return false;
    }

    this.delItem = function(obj){
        ls.ajax.load('/admin/301redirect/ajax/dellink/', {'link[old]': $(obj).data('old')}, function(result) {
            if (result.bStateError) {
                ls.msg.error(null,result.sMsg);
            } else {
                if (result.sMsg) ls.msg.notice(null,result.sMsg);
                // удаляем из списока
                $(obj).parents('tr').animate({opacity: 0}, '1000', function(){ $(this).remove(); });
            }
        }.bind(this));
        return false;
    };



    return this;
}).call(ls.redirect.admin || {},jQuery);


/**
 * Активируем форму
 */
jQuery(document).ready(function($){
    $('#redirect-form').bind('submit', function(){
        ls.redirect.admin.addItem('#redirect-form');
        return false;
    });
    ls.redirect.admin.bindDelItem('table.redirect .actions-delete');
    ls.redirect.admin.bindChangeStatus('table.redirect .form_plugins_checkbox');
});