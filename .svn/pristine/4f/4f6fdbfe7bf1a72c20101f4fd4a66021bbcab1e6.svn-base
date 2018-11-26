<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div id="app">
    <add></add>
    <modal v-model="modal" title="商品分组" fullscreen>
        <group></group>
    </modal>
</div>

{{--第三方库引入开始--}}
<link rel="stylesheet" href="{{ asset('lib/iview/styles/iview.css') }}">

@if(env('APP_ENV') == 'local')
    <script src="//cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script src="//unpkg.com/iview/dist/iview.js"></script>
    <script src="//cdn.bootcss.com/axios/0.19.0-beta.1/axios.js"></script>
    <script src="//unpkg.com/vuex@3.0.1/dist/vuex.js"></script>
@else
    <script src="{{ asset('lib/vue.min.js') }}"></script>
    <script src="{{ asset('lib/iview/iview.min.js') }}"></script>
    <script src="{{ asset('lib/axios.min.js') }}"></script>
    <script src="{{ asset('lib/vuex.min.js') }}"></script>
@endif

<script src="{{ asset('lib/Sortable.min.js') }}"></script>
<script src="{{ asset('lib/vuedraggable.min.js') }}"></script>
{{--第三方库引入结束--}}

@include('vue.vue_components.goods_card.store');
@include('vue.vue_components.goods_card.goodsGroup');

<script>

    let vm = new Vue({
        el: '#app',
        store, // 挂载store
        components: { 'add':addGoodsGroup, 'group':goodsGroup},
        created(){
            // 获取分组
            let that = this;
            that.$store.commit('getGoodsGroup');
        },
        data: {
            modal: true,
        },
        methods: {
            goodsSelect(arr) {
                console.log(arr);
            }
        }
    });

</script>
</body>
</html>