jQuery(document).ready(function () {
  jQuery("#forms-css").remove();
  jQuery("#fpfm-file-connected").elfinder({
    url: ajaxurl,
    handlers: {
      dblclick: function (event, elfinderInstance) {
        event.preventDefault();
        elfinderInstance
          .exec("getfile")
          .done(function () {
            try {
              elfinderInstance.exec("edit");
            } catch (e) {
              elfinderInstance.exec("quicklook");
            }
          })
          .fail(function () {
            elfinderInstance.exec("open");
          });
      },
    },
    getFileCallback: function (files, fm) {
      return false;
    },
    contextmenu: {
      // current directory file menu
      files: [
        "getfile",
        "|",
        "open",
        "opennew",
        "download",
        "opendir",
        "quicklook",
        "email",
        "|",
        "upload",
        "mkdir",
        "|",
        "copy",
        "cut",
        "paste",
        "duplicate",
        "|",
        "rm",
        "empty",
        "hide",
        "|",
        "rename",
        "edit",
        "resize",
        "|",
        "archive",
        "extract",
        "|",
        "selectall",
        "selectinvert",
        "|",
        "places",
        "info",
        "chmod",
        "netunmount",
      ],
      // navbarfolder menu
      navbar: [
        "open",
        "opennew",
        "download",
        "|",
        "upload",
        "mkdir",
        "|",
        "copy",
        "cut",
        "paste",
        "duplicate",
        "|",
        "rm",
        "empty",
        "hide",
        "|",
        "rename",
        "|",
        "archive",
        "|",
        "places",
        "info",
        "chmod",
        "netunmount",
      ],
      // current directory menu
      cwd: [
        "undo",
        "redo",
        "|",
        "back",
        "up",
        "reload",
        "|",
        "upload",
        "mkdir",
        "mkfile",
        "paste",
        "|",
        "empty",
        "hide",
        "|",
        "view",
        "sort",
        "selectall",
        "colwidth",
        "|",
        "places",
        "info",
        "chmod",
        "netunmount",
        "|",
        "fullscreen",
        "|",
      ],
    },
    uiOptions: {
      // toolbar configuration
      toolbar: [
        ["home", "back", "forward", "up", "reload"],
        ["netmount"],
        ["mkdir", "mkfile", "upload"],
        ["open", "download", "getfile"],
        ["undo", "redo"],
        ["copy", "cut", "paste", "rm", "empty"],
        ["duplicate", "rename", "edit", "resize", "chmod"],
        ["selectall", "selectnone", "selectinvert"],
        ["quicklook", "info"],
        ["extract", "archive"],
        ["search"],
        ["view", "sort"],
        ["help"],
        ["fullscreen"],
      ],
      toolbarExtra: {
        // show Preference button into contextmenu of the toolbar (true / false)
        preferenceInContextmenu: false,
      },
    },
    ui: ["toolbar", "tree", "path", "stat"],
    customData: {
      action: "rpfm_fm_connector",
      nonce: rpfm_connector_data.nonce,
    },
    lang: "en",
    requestType: "get",
    width: "auto",
    height: "600",
  });
});
