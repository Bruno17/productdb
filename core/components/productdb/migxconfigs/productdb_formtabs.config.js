{
  "id":6,
  "name":"productdb_formtabs",
  "formtabs":[
    {
      "MIGX_id":11,
      "caption":"General",
      "print_before_tabs":"0",
      "fields":[
        {
          "MIGX_id":25,
          "field":"name",
          "caption":"name",
          "pos":1
        },
        {
          "MIGX_id":26,
          "field":"type",
          "caption":"type",
          "description":"",
          "description_is_code":"0",
          "inputTV":"",
          "inputTVtype":"listbox",
          "validation":"",
          "configs":"",
          "restrictive_condition":"",
          "display":"",
          "sourceFrom":"config",
          "sources":"",
          "inputOptionValues":"global||translations",
          "default":"",
          "useDefaultIfEmpty":"0",
          "pos":2
        }
      ],
      "pos":1
    },
    {
      "MIGX_id":12,
      "caption":"Fields",
      "print_before_tabs":"0",
      "fields":[
        {
          "MIGX_id":27,
          "field":"fields",
          "caption":"Fields",
          "description":"",
          "description_is_code":"0",
          "inputTV":"",
          "inputTVtype":"migx",
          "validation":"",
          "configs":"productdb_formtab_fields",
          "restrictive_condition":"",
          "display":"",
          "sourceFrom":"config",
          "sources":"",
          "inputOptionValues":"",
          "default":"",
          "useDefaultIfEmpty":"0",
          "pos":1
        }
      ],
      "pos":2
    }
  ],
  "contextmenus":"",
  "actionbuttons":"addItem",
  "columnbuttons":"update||publish||unpublish",
  "filters":"",
  "extended":{
    "migx_add":"",
    "disable_add_item":"",
    "add_items_directly":"",
    "formcaption":"",
    "update_win_title":"",
    "win_id":"productdb_formtabs",
    "maxRecords":"",
    "addNewItemAt":"bottom",
    "media_source_id":"",
    "multiple_formtabs":"",
    "multiple_formtabs_label":"",
    "multiple_formtabs_field":"",
    "multiple_formtabs_optionstext":"",
    "multiple_formtabs_optionsvalue":"",
    "actionbuttonsperrow":4,
    "winbuttonslist":"",
    "extrahandlers":"",
    "filtersperrow":4,
    "packageName":"productdb",
    "classname":"productdbFormtab",
    "task":"",
    "getlistsort":"",
    "getlistsortdir":"",
    "sortconfig":"",
    "gridpagesize":"",
    "use_custom_prefix":"0",
    "prefix":"",
    "grid":"",
    "gridload_mode":1,
    "check_resid":1,
    "check_resid_TV":"",
    "join_alias":"",
    "has_jointable":"yes",
    "getlistwhere":"",
    "joins":"",
    "hooksnippets":{
      "aftersave":"productdb_aftersave_formtabs"
    },
    "cmpmaincaption":"Productdb",
    "cmptabcaption":"Formtabs",
    "cmptabdescription":"Manage Formtabs here",
    "cmptabcontroller":"",
    "winbuttons":"",
    "onsubmitsuccess":"",
    "submitparams":""
  },
  "columns":[
    {
      "MIGX_id":2,
      "dataIndex":"id",
      "header":"id"
    },
    {
      "MIGX_id":3,
      "header":"name",
      "dataIndex":"name",
      "width":"",
      "sortable":true,
      "show_in_grid":1,
      "customrenderer":"",
      "renderer":"this.renderRowActions",
      "clickaction":"",
      "selectorconfig":"",
      "renderchunktpl":"",
      "renderoptions":"",
      "editor":""
    },
    {
      "MIGX_id":4,
      "dataIndex":"type",
      "header":"type"
    }
  ],
  "createdby":1,
  "createdon":"2018-02-22 18:01:21",
  "editedby":1,
  "editedon":"2018-02-24 11:49:53",
  "deleted":0,
  "deletedon":null,
  "deletedby":0,
  "published":1,
  "publishedon":null,
  "publishedby":0,
  "category":""
}