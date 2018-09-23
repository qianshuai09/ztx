function api(url) {
  var api = 'https://ztx.hfxyzq.cn/portal/wx/'
  return api + url
}

// module.exports api = function(url){
//   var api='https://pin.diguikeji.com/api/wxapp/'
//   return api+url
// }

module.exports = {
  api: api
}