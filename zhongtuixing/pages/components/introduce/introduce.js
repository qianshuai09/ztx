var app = getApp()
Page({
  data: {
    swiperList: [{//除了1，2之外，其它的swpClass都是swp-rightNo
      swpClass: "swp-center",
      name: "xyDideo",
      introduce: "著名网络编程工程师，曾任职于科大讯飞",
      imgsrc: "../../../image/test.png"
    }, {
      swpClass: "swp-right",
        name: "xyDideo1",
        introduce: "著名网络编程工程师，曾任职于科大讯飞",
        imgsrc: "../../../image/test.png"
    }, {
      swpClass: "swp-rightNo",
        name: "xyDideo2",
        introduce: "著名网络编程工程师，曾任职于科大讯飞",
        imgsrc: "../../../image/test.png"
    }]
  },


  swpBtn: function (e) {
    var swp = this.data.swiperList;
    var max = swp.length;
    var idx = e.currentTarget.dataset.index;
    var prev = swp[idx - 1];//前一个
    var next = swp[idx + 1];//后一个
    var curView = swp[idx];//当前
    if (curView.swpClass === 'swp-center') {//如果当前是在中间的，即可跳转
      wx.navigateTo({
        url: curView.aurl,
      })
    }

    if (prev) {//如果当前的前面有
      if (next) {//当前的后面有
        next.swpClass = "swp-right";
      }
      prev.swpClass = "swp-left";
      curView.swpClass = "swp-center";
      for (var i = 0; i < idx; i++) { //当前前一个的前面所有
        swp[i].swpClass = 'swp-leftNo'
      }
    }
    if (next) {//如果当前的后面有
      if (prev) {//当前的前面有
        prev.swpClass = "swp-left";
      }
      curView.swpClass = "swp-center";
      next.swpClass = "swp-right";
      for (var i = (idx + 2); i < max; i++) {//当前后一个的后面所有
        swp[i].swpClass = 'swp-rightNo'
      }
    } else {
      prev.swpClass = "swp-left";
      curView.swpClass = "swp-center";
    }

    this.setData({
      swiperList: swp
    })
  },








  onLoad: function () {

    var aboutUrl = "about";
    wx.request({
      url: getApp().api(aboutUrl),
      success:function(res){
        console.log(res)

        var photo = res.data.photo.purl;
        var splitphoto = JSON.stringify(photo);

        var a = '';
        for (var i = 0; i < photo.length; i++) {
          a += photo[i]['url'] + ',';
        } 

        console.log(a)
         this.setData({
           'about':res.data.about,
           'clubs': a
          
         })
      }.bind(this)
    })
  }
  ,


  onShareAppMessage: function () {
    // 用户点击右上角分享
    return {
      title: '众推行', // 分享标题
      desc: '哎哟不错哦', // 分享描述
      path: 'pages/index/index' // 分享路径
    }
  }

})
