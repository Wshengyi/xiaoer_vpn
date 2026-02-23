define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'subscription/index' + location.search,
                    add_url: 'subscription/add',
                    edit_url: 'subscription/edit',
                    del_url: 'subscription/del',
                    multi_url: 'subscription/multi',
                    import_url: 'subscription/import',
                    table: 'subscription',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'plan_id', title: __('Plan_id')},
                        {field: 'sub_status', title: __('Sub_status'), searchList: {"有效":__('有效'),"已暂停":__('已暂停'),"已取消":__('已取消')}, formatter: Table.api.formatter.status},
                        {field: 'next_billing_date', title: __('Next_billing_date'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'used_upload_gb', title: __('Used_upload_gb'), operate:'BETWEEN'},
                        {field: 'used_download_gb', title: __('Used_download_gb'), operate:'BETWEEN'},
                        {field: 'clash_url', title: __('Clash_url'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'shadowrocket_url', title: __('Shadowrocket_url'), operate: 'LIKE', formatter: Table.api.formatter.url},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
