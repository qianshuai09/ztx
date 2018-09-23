
var app = getApp()
//var openid = getApp().globalData.openid; 
var openid = app.getCache('openid')
Page({
  data: {

    list: [
      { 'num': '社团赞助' },
      { 'num': '实习单位' },
      { 'num': '公益活动' }
    ],
    btnText_apply: "申请",
    idx: 0,

  },

  imgTap:function(e){
    var pid = e.currentTarget.dataset.pid;
    wx.navigateTo({
      url: '../../components/sponsor/sponsor?pid='+pid,
    })

  },

  activeImgTap:function(e){
    var pid = e.currentTarget.dataset.pid;
    wx.navigateTo({
      url: '../../components/activity/activity?pid='+pid,
    })
  },

  workimgTap:function(e){
    var pid = e.currentTarget.dataset.pid;
    wx.navigateTo({
      url: '../../components/work/work?pid=' + pid,
    })
  },

  deleteZan:function(e){
    var pid = e.currentTarget.dataset.pid;
    wx.showModal({
      title: '删除',
      content: '确定删除此赞助?',
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定')
          console.log(pid)

          var loveDeleteUrl = "deleteLove"
          var _this = this
          wx.request({
            url: getApp().api(loveDeleteUrl),
            data:{
              pid:pid,
              openid:getApp().getCache("openid")
            },
            success:function(res){
              console.log(res)
              if(res.data.code==1000){
                   wx.showToast({
                     title: '喜欢删除成功',
                     duration:2000,
                     mask:false,
                     success:function(){
                       wx.navigateBack({

                       })
                     }
                   })
              }
            }
          })
        

        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })  
  },

  flushOrder:function() {
    console.log('监听开始')
    this.onLoad()
  },

  goIndex(e) {
    let index = e.currentTarget.dataset.index;
    // console.log('每个index',index)
    var _this = this;
    var urlDetail = 'myLove';
    this.setData({
      idx: index,
    })


    var num = index
    if (num == 0) {

      console.log("0");
      this.setData({
        'param': 0
      })

  
      wx.request({
        url: app.api(urlDetail),
        data: {
          cid: 1,
          openid: openid,
        },
        success: function (res) {
          console.log(res)
          _this.setData({
            'detailOne': res.data
          })
        }
      })




    } else if (num == 1) {

      console.log("1")
      this.setData({
        'param': 1
      })
      wx.request({
        url: app.api(urlDetail),
        data: {
          cid: 2,
          openid: openid,
        },
        success: function (res) {
          console.log(res)
          _this.setData({
            'detailTwo': res.data
          })
        }
      })



    } else if (num == 2) {

      console.log("2")
      this.setData({
        'param': 2
      })
      wx.request({
        url: app.api(urlDetail),
        data: {
          cid: 3,
          openid: openid,
        },
        success: function (res) {
          console.log(res)
          _this.setData({
            'detailThree': res.data
          })
        }
      })


    }

  },



  onShow:function(){
     this.onLoad();
  },

  onLoad: function () {

    /* wx.getStorage({
         key: 'openid',
         success: function (res) {
           console.log(res.data)
           var openid = res.data
 
         }
       })*/




    this.setData({
      'param': 0
    });


    var urlDetail = 'myLove';
    var _this = this
    wx.request({
      url: app.api(urlDetail),
      data: {
        cid: 1,
        openid: openid,
      },
      success: function (res) {
        console.log(res)
        _this.setData({
          'detailOne': res.data
        })
      }
    })



    //渲染banner轮播图片
    var urlBanner = 'banner'
    wx.request({
      url: app.api(urlBanner),
      method: "GET",
      data: {
        bid: 1
      },
      success: function (res) {
        console.log(res)
        
      }
    })

    //渲染所有活动


    //渲染所有的分类
    var urlCategory = "category";
    var _this = this
    wx.request({
      url: app.api(urlCategory),
      method: "GET",
      success: function (res) {
        console.log(res)
        _this.setData({
          typeArr: res.data
        })
      }
    })

  }
  ,


  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

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

  onShareAppMessage: function () {
    // 用户点击右上角分享
    return {
      title: '众推行', // 分享标题
      desc: '哎哟不错哦', // 分享描述
      path: 'pages/index/index' // 分享路径
    }
  }

})
