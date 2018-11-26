<style>
    .card:hover {
        border: 0px rgba(136, 130, 127, 0.17) solid;
        box-shadow: 1px 1px 4px #888888;
    }

    .card-content > div > div > div {
        margin-top: 5px;
    }

    .search-position {
        float: left;
        margin-right: 16px;
        margin-top: 5px;
    }

    .shop-search-config {
        margin-left: 15px;
    }

    .card-url {
        height: 36px;
        overflow: hidden;
    }

    .card-url a:hover {
        color: #57a3f3 !important;
    }

    .goods-select {
        background-color: #8bfffa;
    }

    .card-recommend {
        height: 22px;
        line-height: 22px;
        width: 34px;
        background: #ED4040;
        color: #FFF;

        position: absolute;
        top: 5px;
        left: 5px;
        text-align: center;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    .card-content a:link{
        color: #57a3f3 !important;
    }

    .card:hover .goods-same{display: block !important;}

    /*解决样式冲突*/
    .ivu-modal-footer{
        padding:0 !important;
    }
</style>


<link rel="stylesheet" href="<?php echo e(asset('lib/iview/styles/iview.css')); ?>">

<?php if(env('APP_ENV') == 'local'): ?>
    <script src="//cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script src="//unpkg.com/iview/dist/iview.js"></script>
    <script src="//cdn.bootcss.com/axios/0.19.0-beta.1/axios.js"></script>
    <script src="//unpkg.com/vuex@3.0.1/dist/vuex.js"></script>
<?php else: ?>
    <script src="<?php echo e(asset('lib/vue.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/iview/iview.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/axios.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/vuex.min.js')); ?>"></script>
<?php endif; ?>

<script src="<?php echo e(asset('lib/Sortable.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/vuedraggable.min.js')); ?>"></script>


<?php echo $__env->make('vue.vue_components.goods_card.store', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('vue.vue_components.goods_card.feedback', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('vue.vue_components.goods_card.goodsShow', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('vue.vue_components.goods_card.goodsGroup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('vue.vue_components.goods_card.goodsSelectOperate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    var axiosThis; // 把 app 实例，指向此变量，用于 axios 响应配置

    // 商品卡组件
    Vue.component('goods-card',{
        props: ['modalShow'],
        components: {feedback, goodsShow, addGoodsGroup, goodsGroup, goodsSelectOperate},
        template:`
            <div>
                <Button @click="modal = true" type="warning">选择商品</Button>
                <modal v-model="modal" title="选择商品" fullscreen>
                    <div slot="header" style="font-size: 16px;">
                        <span>选择商品</span>
                        <Icon style="color:#f60;margin-left: 20px" type="ios-information-circle"></Icon>
                        <span style="color:#f60;">查不到外部店铺商品时，确认是否关闭了【是否自有】、【推荐商品】，并且做了【重置】操作。</span>
                        <feedback></feedback>
                    </div>
                    <Row type="flex" justify="center">
                        <Col span="23" id="up">
                            <Tabs v-model="tab">
                                <tab-pane label="全部" name="1">
                                    <goodsShow :shop_type="3"></goodsShow>
                                </tab-pane>
                                <tab-pane label="小店" name="2">
                                    <goodsShow :shop_type="1"></goodsShow>
                                </tab-pane>
                                <tab-pane label="放心购" name="3">
                                    <goodsShow :shop_type="0"></goodsShow>
                                </tab-pane>
                                <tab-pane label="商品分组" name="4">
                                    <goodsGroup></goodsGroup>
                                </tab-pane>
                            </Tabs>
                        </Col>
                    </Row>
                    <div slot="footer" class="modal-footer">
                        <div style="display: flex; justify-content: center;">
                            <Row type="flex" justify="center">
                                <i-button style="margin-left: 15px;width: 110px" type="warning" @click="modalHide">确定</i-button>
                            </Row>
                            <goodsSelectOperate></goodsSelectOperate>
                            <addGoodsGroup></addGoodsGroup>
                        </div>
                    </div>
                </modal>
            </div>
        `,
        created() {
            let that = this;

            axiosThis = this;

            bus.$on('getGoodsGroup', () => {
                that.$store.commit('getGoodsGroup');
            });

            bus.$on('tabChange', (index) => {
                console.log('执行了');
                that.tab = index.toString();
            });

            // 获取分类
            axios.get("<?php echo e(asset('js/category_our_v1.json')); ?>").then(function (response) {
                that.$store.commit('addCategories',response.data);
            });

            // 获取店铺搜索配置
            axios.get("<?php echo e(route('temai_goods_search_config/get_shop')); ?>").then(r => {
                that.$store.commit('getShopConfig',r.data);
                bus.$emit('getGoodsData');
            });

            // 获取分组
            that.$store.commit('getGoodsGroup');
        },
        data() {
            return {
                tab: '1',
                modal: this.modalShow === true ? true: false,
            }
        },
        methods: {
            modalHide() { // 模态框隐藏，返回已选数据
                this.modal = false;
                this.$emit('goods-select',this.$store.state.goodsSelect);
                this.$store.commit('delAllGoodsSelect');
                bus.$emit('syncGoodsSelectStyle');
            }
        }
    });
</script>