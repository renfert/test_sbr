// This is your plugin object. It can be exported to be used anywhere.
const MyPlugin = {
    install(Vue, options) {
        Vue.directive('my-directive', {
            bind (el, binding, vnode, oldVnode) {
                console.log()
            }
        })
    }
  };
  
  export default MyPlugin;