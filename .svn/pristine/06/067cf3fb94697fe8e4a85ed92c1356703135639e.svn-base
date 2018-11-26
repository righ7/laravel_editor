<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div id="app">
    <goods-card :modal-show="true" @goods-select="goodsSelect"></goods-card>
</div>

@include('vue.vue_components.goods_card.goodsCard')

<script>
    /**
     * 加载文件 include goodsCard
     * 添加 <goods-card> 标签，并添加 @goods-select 方法
     * 在 vue 实例上挂载 store
     * 在 vue 实例增加 @goods-select 事件方法， 参数为已选择的商品数据
     * :modal-show true 为 打开， false 为关闭， 默认关闭
     */
    let vm = new Vue({
        el:'#app',
        store, // 挂载store
        methods: {
            goodsSelect(arr){
                console.log(arr);
            }
        }
    });

</script>
</body>
</html>