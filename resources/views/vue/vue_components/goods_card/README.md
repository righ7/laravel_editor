## 商品卡组件简述
> 进行开发前，请先阅读`vue.js`、`vuex` 文档。  
> 开发请加载开发版`js`, 生产请加载 `.min` 的`js`，并安装 `Vue DevTools` 进行调试。   
> **开发请遵循组件开发规范**

### 文件简述[省略 .blade.php 后缀]
 
#### store
* bus 事件总线，用户组件间事件通知
* vuex 实例，存放组件间公用的数据、方法，使用方法请查阅 vuex 文档 

### goodsCard
商品卡组件，包含 样式、引入第三方库、引入的 blade 模板、加载 blade 模板里面的组件
* 接受一个可选参数 modalShow，用来指定 modal 是打开还是关闭，值 bool， 默认 false
* 方法 goods-select，用于在 modal 关闭时返回已选商品数据

### 其他
* feedback 反馈组件
* goodsGroup 商品分组组件（2个）
* goodsSelectOperate 已选商品组件
* goodsShow 商品选择主体组件

### vue 初始化流程
1. 父组件 created()
2. 子组件 created()
3. 子组件 mounted()
4. 父组件 mounted()