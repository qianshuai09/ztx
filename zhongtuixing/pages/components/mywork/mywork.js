// pages/components/work/work.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    disabled_love: false,
    disabled_apply: false,
    btnText_love: "喜欢",
    btnText_apply: "申请",
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    var mid = options.mid;
    
    var jobUrl = 'selectWork'
    var _this = this
    wx.request({
      url: getApp().api(jobUrl),
      data:{
       mid:mid
      },
      success:function(res){
        console.log(res)
        _this.setData({
          'data':res.data
        })
      }
    })
  
  },



  loveTap: function () {
    var _this = this
    var pid = this.data.pid;
    console.log("########" + pid)
    var loveUrl = 'love';
    wx.request({
      url: getApp().api(loveUrl),
      data: {
        pid: pid,
        openid: getApp().getCache('openid')
      },
      success: function (res) {
        console.log(res)
        if (res.data.code == 1000) {
          wx.showToast({
            title: '喜欢上啦',
            success: function () {
              //页面刷新
              _this.setData({
                disabled_love: !_this.data.disabled,
                btnText_love: '已喜欢'
              })

            }
          })
          return
        }
      }
    })
  },

  applyJob: function (e) {
    var mid = e.currentTarget.dataset.mid
    var _this = this
    var applyUrl = 'applyJobButton';
    console.log("########" + mid)
    wx.request({
      url: getApp().api(applyUrl),
      data: {
        mid:mid,
        openid: getApp().getCache('openid')
      },
      success: function (res) {
        if (res.data.code == 1000) {
          console.log(res)
          wx.showToast({
            title: '申请上啦',
            success: function () {
              //页面刷新
              _this.setData({
                disabled_apply: !_this.data.disabled,
                btnText_apply: '已申请'
              })
            }
          })

          return
        }
      }
    })
  },





  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})