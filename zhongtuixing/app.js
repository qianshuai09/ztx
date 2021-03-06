//app.js
const api = require("utils/api.js");
App({
  onLaunch: function () {

  },
  getCache: function (key) {
    var value = undefined;
    try {
      var value = wx.getStorageSync(key)
    } catch (e) {

    }
    return value;

  },
  setCache: function (key, value) {
    wx.setStorage({
      key: 'key',
      data: 'value',
    })
  },
  alert: function (params) {
    var title = params.hasOwnProperty('title') ? params['title'] : '提示信息';
    var content = params.hasOwnProperty('content') ? params['content'] : '';
    wx.showModal({
      title: title,
      content: content,
      showCancel: false,
      success: function (res) {
        if (res.confirm) {//用户点击确定
          if (params.hasOwnProperty('cb_confirm') && typeof (params.cb_confirm) == "function") {
            params.cb_confirm();
          }
        } else {
          if (params.hasOwnProperty('cb_cancel') && typeof (params.cb_cancel) == "function") {
            params.cb_cancel();
          }
        }
      }
    })  
  },

  getRequestHeader: function () {
    return {
      'content-type': 'application/x-www-form-urlencoded'
    }
  },
  globalData: {
    userInfo: null,
  },
  api:api.api
})