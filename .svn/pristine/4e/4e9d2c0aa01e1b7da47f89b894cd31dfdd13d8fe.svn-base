@include('vue.vue_components.goods_card.goodsCard')
{{--本来我写的代码不是这样的,乱七八糟的改...--}}
{{--请牢记下面这句话--}}
{{--Done is better than Perfect--}}
<style>
    .preview-article-content{
        width: 312px;
        height: 555px;
        background-color: #1b1b1b;
        overflow: hidden;
        margin-left: 25px;
        margin-top: 5px;
        padding: 90px 4px 0 4px;
        position: relative;
    }
    .phone-des{
        display: inline-block;
        width: 100%;
        height: 180px;
        position: absolute;
        left: 0;
        bottom: 0;
        background: rgba(27,27,27,.7);
    }
    .goods-title{
        margin: 10px 15px 12px;
        height: 32px;
        line-height: 32px;
        overflow: hidden;
        color: #fff;
        font-size: 18px;
    }
    .tt-des{
        color: #cacaca;
        font-size: 16px;
        line-height: 22px;
        max-height: 178px;
        word-break: break-all;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow-x: hidden;
        margin-left: 15px;
    }
    .title_tip{
        position: absolute;
        top: 6px;
        right: 0;
        color: #999;
        z-index: 9;
    }
    .title_tip.warning{
        color: #ed4040;
    }
    .input-groupsss{
        padding: 0px;
        position: relative;
        width: 100%;
    }

    [v-cloak] {
        display: none;
    }
</style>
<div id="app">
    <Row  type="flex" justify="center" v-cloak>
        <i-col span="23.5">
            <br/>
            <span>生成篇数：</span>
            <input-number v-model="articleAmount"></input-number>
            <span style="margin-left:10px;">每篇产品数：</span>
            <input-number :min="10" v-model="articleContentGoodsAmount" placeholder="默认 12 个"></input-number>
            <span style="margin-left:10px;">推荐商品「 @{{ goodsRecommendLength }} 」
                <Tooltip max-width="300" content="勾选此项，表示所有生成文章前三个商品将从推荐商品中随机选取排列，请保证所选商品中至少有三个推荐商品！">
                    <Icon style="font-size: 15px;" type="md-help-circle" />
                </Tooltip>
            </span>
            <i-switch v-model="article_is_recommend">
                <Icon type="md-checkmark" slot="open"></Icon>
                <Icon type="md-close" slot="close"></Icon>
            </i-switch>
            <goods-card @goods-select="goodsSelectData" style="display: inline;"></goods-card>
            <i-button type="info" @click="modalFavoriteGoods = true">已选商品 ( @{{ generateGoodsData.length }} )</i-button>

            <br/>
            <div style="margin-top: 10px;">
                <radio-group v-model="disabledGroup" @on-change="radiochange">
                    <Radio label="0">『图集』</Radio>
                    <Radio :label="item.id" v-for="(item,index) in template" :key="index">@{{ item.template_name }}</Radio>
                </radio-group>

                <i-button :loading="loading.default" type="primary" @click="getProduceArticle()" :disabled="loading.disabled">
                    <span v-if="!loading.default">2.生成</span>
                    <span v-else>生成中...</span>
                </i-button>
                <Poptip
                        style="margin-left: 20px;"
                        :style="{ display: templateHideStyle }"
                        confirm
                        title="确认存为图集草稿？"
                        @on-ok="saveImgCollection">
                    <i-button type="info">3.存为图集</i-button>
                </Poptip>

                <Poptip
                        confirm
                        title="确认存为专辑草稿？"
                        :style="{ display: templateHideStyle1 }"
                        @on-ok="saveAlbum">
                    <i-button type="info">3.存为专辑</i-button>
                </Poptip>
                <Poptip
                        style="margin-left: 20px;"
                        confirm
                        title="确认删除所选文章？"
                        @on-ok="delSelectArticle">
                    <i-button type="error">批量删除</i-button>
                </Poptip>
                <span style="margin-left: 20px; color: red;" v-if="empty_description_goods_amount != 0">
                    自动清除无描述商品数：「 @{{ empty_description_goods_amount }} 」
                </span>
                <span style="float: right;">
                    <i-button type="primary" @click="href">我的发文</i-button>
                </span>
            </div>
            <br/>
            <i-table ref="selection" :columns="tableColumn" :data="tableData"></i-table>

            <modal v-model="modalFavoriteGoods" title="已收藏商品" :styles="{top: '0'}">
                <div style="display: flex; justify-content: flex-end;" v-if="generateGoodsData.length != 0">
                    <i-button type="error" size="small" @click="clearFavoriteAll">清空全部</i-button>
                </div>
                <div style="margin-bottom: 10px; margin-top:10px;height: 120px;" v-for="goodsSelect in generateGoodsData">
                    <div style="width: 20%; float: left;">
                        <img :src="goodsSelect.img" width="100%">
                    </div>
                    <div style="width: 92%; position: relative; left: 20px;">
                        <div v-if="goodsSelect.is_recommend == 1" style="left: -15px;" class="card-recommend">推荐</div>
                        <span><a :href="goodsSelect.sku_url" target="_blank">@{{ goodsSelect.name }}</a></span><br/>
                        <span style="color: red;font-size: 20px;">￥@{{ goodsSelect.discount_price | price }}</span><br/>
                        <span style="color: red;font-size: 15px;">佣金：@{{ goodsSelect.cos_ratio | commission_earnings(goodsSelect.discount_price / 100)  }}</span>
                        <span style="float:right;"><i-button size="small" type="warning" @click="delFavoriteGoods(goodsSelect.product_id)">取消</i-button></span>
                    </div>
                </div>
                <div style="display: flex; justify-content:center;" v-if="generateGoodsData.length == 0">暂无数据</div>
            </modal>
            <!--图集预览开始-->
            <modal v-model="picPreview" width="400" title="预览" :styles="{top: '0'}" >
                <div v-for="g in modalPreviewArticle">
                    <div class="preview-article-content">
                        <img :src="g.img[0]" width="100%">
                        <div class="phone-des">
                            <p class="goods-title">
                                <span v-if="g.goods_detail.name == 1">
                                    @{{ g.goods_detail.name }}
                                </span>
                            </p>
                            <p class="tt-des" style="margin-top: 10px; margin-bottom: 10px;">@{{ g.main_description }}</p>
                        </div>

                    </div>
                    <div class="preview-article-content">
                        <img :src="g.img[1]" width="100%">

                        <div class="phone-des">
                            <p class="goods-title">
                                <span v-if="g.goods_detail.name == 1">
                                    @{{ g.goods_detail.name }}
                                </span>
                            </p>
                            <p class="tt-des" style="margin-top: 10px; margin-bottom: 10px;">@{{ g.vice_description }}</p>
                        </div>
                    </div>
                    <br/><br/><br/><br/>
                </div>
            </modal>
            <!--图集预览结束-->
            <modal v-model="template_modal" width="300" title="预览" :styles="{top: '0'}">
                <div style="margin-bottom: 10px;" v-for="(g, index) in album_template_data">
                    <template v-if="Object.getOwnPropertyNames(g).includes('t')">
                        <img :src="g.t" width="100%">
                    </template>
                    <template v-if="Object.getOwnPropertyNames(g).includes('m')">
                        @{{ g.m }}
                    </template>
                    <template v-if="Object.getOwnPropertyNames(g).includes('card')">
                        <div style="clear: both; height: 60px;">
                            <div style="float: left; width: 25%; margin-bottom: 15px;">
                                <img :src="g.card.img" width="100%">
                            </div>
                            <div style="float: left; width: 74%;background-color: #bfbfbf; height: 67px;">
                                <span>@{{ g.card.title }}</span><br/>
                                <span style="color: red;">￥@{{ g.card.price | price }}</span>
                            </div>
                        </div>
                    </template>
                    <template v-if="Object.getOwnPropertyNames(g).includes('f')">
                        <img :src="g.f" width="100%">
                    </template>
                </div>
            </modal>
        </i-col>
    </Row>
    <back-top></back-top>
</div>

<script>

    let vm = new Vue({
        el: '#app',
        store,
        data() {
            return {
                lastName:'',
                disabledGroup:"0",
                goodsSelect: 'goods-select',
                generateGoodsData:[],
                articleAmount: 1,
                articleContentGoodsAmount: 12,
                article_is_recommend: false,
                tableColumn: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    },
                    {
                        title: '标题',
                        key: 'title',
                        width: 350,
                        render (h,param){
                            let row = param.row;
                            return h('div',{
                                attrs:{
                                    class:'input-groupsss'
                                }
                            },[
                                h('Input', {
                                    props: {
                                        value: row.title,
                                    },
                                    attrs: {
                                        maxlength:30,
                                        class:'input-length'
                                    },
                                    on: {
                                        'on-blur': (event) => {
                                            vm.tableData[param.index].title = event.target.value;
                                        }
                                    }
                                })
                            ])
                        }
                    },
                    {
                        title: '产品图',
                        key: 'third_img',
                        render(h, params) {
                            let row = params.row;
                            let rd = [];
                            let goods = row.goods;

                            for(let i = 0; i < goods.length; i++){
                                let hd = h('Tooltip', {
                                    props: {
                                        content: goods[i].goods_detail.name,
                                        placement: 'top',
                                        'max-width': 200
                                    }
                                }, [
                                    h('a', {
                                        attrs: {
                                            href: goods[i].goods_detail.sku_url,
                                            target: '_blank'
                                        }
                                    }, [
                                        h('img', {
                                            attrs: {
                                                src: goods[i].goods_detail.img,
                                                width: '50',
                                                height: '50'
                                            }
                                        })
                                    ])
                                ]);
                                rd.push(hd);
                            }
                            return h('div', rd);
                        }
                    },
                    {
                        title: '商品数',
                        key: 'goods_amount',
                        width: 100
                    },
                    {
                        title: '操作',
                        key: 'operation',
                        width:80,
                        render (h, params){
                            let row = params.row;
                            return h('div',[
                                h('i-button', {
                                    props: {
                                        size: 'small',
                                        type: 'primary'
                                    },
                                    on: {
                                        click:()=> {
                                            vm.modalPreviewArticle = row.goods;
                                            switch (Number(vm.articleTemplate)){
                                                case 0:
                                                    vm.picPreview = true;
                                                    break;
                                                default:
                                                    vm.albumPerview();
                                                    break;
                                            }
                                        }
                                    }
                                }, '预览')
                            ]);
                        }
                    }
                ],
                tableData: [],
                modalPreview: false,
                picPreview: false,
                template1: false,
                template2: false,
                modalPreviewArticle:[],
                modalFavoriteGoods:false,
                loading: {
                    default: false,
                    template1: false,
                    template2: false,
                    disabled:false
                },
                articleTemplate: 0,
                goodsRecommendLength: 0,
                empty_description_goods_amount: 0,
                generateArticleButtonName: '生成文章',
                templateHideStyle: 'inline',
                templateHideStyle1: 'none',
                goodsGroupPreventStateChangeId: 0,
                template:[],
                template_template: [],
                template_modal: false,
                album_template_data: [],
            }
        },
        methods: {
            clearGoodsDataActiveStatus(obj){
                obj.status = false;
            },
            radiochange(){ //改变radio值
                if (vm.disabledGroup==0){
                    vm.templateHideStyle="inline";
                    vm.templateHideStyle1="none";
                }else {
                    vm.templateHideStyle="none";
                    vm.templateHideStyle1="inline";
                }
            },
            goodsSelectData(goodsSelectData) { // modal 点击确认事件
                    let that = this;
                    let goods_id = [];
                    goodsSelectData.map((item)=>{
                        goods_id.push(item.goods_id);
                    });

                    axios.get("{{ route('mass_production/putch') }}", {
                        params: {
                            goods_id: goods_id,
                            type: 1
                        }
                    }).then(function (response) {
                        that.$Message.success('操作成功');
                        that.getFavoriteGoods();
                    }).catch(function (error) {
                        console.log(error);
                    });
            },
            getFavoriteGoods(){ // 获得用户收藏数据
                axios.get("{{ route('mass_production/get_favorite_goods') }}", {
                    params: {}
                }).then(function (response) {
                    vm.generateGoodsData = response.data;

                    // 装载推荐商品数
                    vm.goodsRecommendLength = 0;
                    vm.generateGoodsData.map(item=>{
                        if(item.is_recommend === 1){
                            vm.goodsRecommendLength++;
                        }
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            getProduceArticle() { // 生成文章
                let that = this;

                if(this.generateGoodsData.length < 1){
                    this.$Message.info('请选择商品');
                    return false;
                }

                that.articleTemplate = vm.disabledGroup;
                that.buttonLoadingStatus(true);

                axios.get(" {{ route('mass_production/produce') }}", {
                    params: {
                        article_amount: this.articleAmount,
                        article_content_goods_amount: this.articleContentGoodsAmount,
                        article_is_recommend: this.article_is_recommend,
                        article_type: this.disabledGroup
                    }
                }).then(function (response) {
                    vm.tableData = response.data;
                    vm.empty_description_goods_amount = response.data[0].empty_description_goods_amount;
                    that.buttonLoadingStatus(false);
                    setTimeout(()=> {
                        vm.handleSelectAll(true);
                    },500);



                }).catch(function (error) {
                    console.log(error);
                });
            },
            clearFavoriteAll() { // 删除全部收藏商品
                axios.get("{{ route('mass_production/putch') }}", {
                    params: {
                        type:3
                    }
                }).then(function (response) {
                    vm.getFavoriteGoods();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            handleSelectAll (status) { // 全选操作
                this.$refs.selection.selectAll(status);
            },
            delSelectArticle() { // 删除所选文章
                let del = [];
                this.tableData.map((item,index)=>{
                    this.$refs.selection.getSelection().map((select)=>{
                        if(item.id === select.id){
                            del.push(index);
                        }
                    });
                });
                del.reverse();
                del.map((item)=>{
                    this.tableData.splice(item,1);
                });
            },
            delFavoriteGoods(product_id) { // 删除单个收藏的商品
                axios.get("{{ route('mass_production/putch') }}", {
                    params: {
                        type: 2,
                        goods_id: product_id
                    }
                }).then(function (response) {
                    vm.getFavoriteGoods();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            saveImgCollection() { // 存为图集
                this.$Spin.show();
                let data = this.$refs.selection.getSelection();

                var next=1;
                for (x in data){
                    if (!data[x].title){
                        next=0;
                        break;
                    }
                }
                if(data.length>0){
                    if (next==0){
                        vm.$Message.warning('标题不能为空');
                        vm.$Spin.hide();
                    }else {
                        axios.post("{{ route('mass_production/save_img_collection') }}", {
                            params: {
                                data: data
                            }
                        }).then(function (response) {
                            vm.$Message.success('操作成功');
                            vm.$Spin.hide();
                            vm.delSelectArticle();
                        }).catch(function (error) {
                            vm.$Spin.hide();
                            console.log(error);
                        });
                    }
                }else {
                    vm.$Message.warning('您还未选择!');
                    vm.$Spin.hide();
                }


            },
            saveAlbum(){ // 存为专辑
                this.$Spin.show();
                let that = this;
                let data = this.$refs.selection.getSelection();
                axios.post("{{ route('mass_production/save_album') }}", {
                    params: {
                        data: data,
                        template: that.articleTemplate
                    }
                }).then(function (response) {
                    vm.$Message.success('操作成功');
                    vm.$Spin.hide();
                    vm.delSelectArticle();
                }).catch(function (error) {
                    vm.$Spin.hide();
                    console.log(error);
                });
            },
            goodsSelectDataDel(index) { // 删除已选商品
                this.goodsSelectData.splice(index,1);
                this.goodsSelectStatuRefresh(this.tab);
            },
            goodsSelectDataDelAll() { // 批量删除已选商品
                this.goodsSelectData = [];
                this.goodsSelectStatuRefresh(this.tab);
            },
            buttonLoadingStatus(status){
                let that = this;
                that.loading.default = status;
                that.loading.disabled = status;
            },
            groupSelectGoodsOpa(selectGoods) { // 判断已选商品是否存在
                let that = this;
                for(let i = 0; i < that.goodsSelectData.length; i++){
                    if(that.goodsSelectData[i].id == selectGoods.id){
                        that.$Message.info('商品已经存在');
                        that.goodsGroupPreventStateChangeId = that.goodsSelectData[i].id;
                        return false;
                    }
                }
                if(selectGoods.status === false){
                    that.goodsSelectData.map((obj, index)=>{
                        if(obj.id == selectGoods.id){
                            that.goodsSelectData.splice(index,1);
                        }
                    });
                }else{
                    that.goodsSelectData.push(selectGoods);
                    that.goodsSelectData.sort();
                }
            },
            href(){
                location.href = '{{ route('articles.index') }}';
            },
            getTemplate() {
                let that = this;
                axios.get('{{ route('mass_production/get_template') }}').then((r) => {
                    that.template = r.data;
                });
            },
            // 专辑模板预览功能
            albumPerview(){
                this.template_modal = true;

                // 提取 template 字符串模板
                let tem = '';
                for(x in this.template){
                    if(this.template[x].id == this.disabledGroup){
                        tem = this.template[x].template;
                        break;
                    }
                }
                this.template_template = tem.split(',');

                let pointer = 0; //指针
                let max_number = 0; // 模板中最大的数字
                let goods_index = 0;
                let while_index = 0;
                this.template_template.forEach((item)=>{
                    if (item.charAt(1) > max_number) max_number = parseInt(item.charAt(1));
                });
                while(this.modalPreviewArticle.length >= pointer){ // >= (pointer + max_number) 将剔除多余模板
                    if(while_index != 0){
                        let tem = [];
                        tem['f'] = 'http://p3a.pstatp.com/large/1f7700011f8c20db3b29';
                        this.album_template_data.push(tem);
                    }
                    while_index++;
                    for(let i = 0; i < this.template_template.length; i++){
                        goods_index = parseInt(this.template_template[i].charAt(1)) - 1;
                        if(this.modalPreviewArticle[pointer + goods_index] == undefined) continue;
                        let tem = [];
                        switch(this.template_template[i].charAt(3)){
                            case 't':
                                if(this.template_template[i].charAt(4) == 1) tem['t'] = this.modalPreviewArticle[pointer + goods_index].img[0];
                                if(this.template_template[i].charAt(4) == 2) tem['t'] = this.modalPreviewArticle[pointer + goods_index].img[1];
                                break;
                            case 'm':
                                if(this.template_template[i].charAt(4) == 1) tem['m'] = this.modalPreviewArticle[pointer + goods_index].main_description;
                                if(this.template_template[i].charAt(4) == 2) tem['m'] = this.modalPreviewArticle[pointer + goods_index].vice_description;
                                break;
                            case 'c':
                                let tem1 = [];
                                tem1['title'] = this.modalPreviewArticle[pointer + goods_index].goods_detail.name;
                                tem1['img'] = this.modalPreviewArticle[pointer + goods_index].goods_detail.img;
                                tem1['price'] = this.modalPreviewArticle[pointer + goods_index].goods_detail.discount_price / 100;
                                tem['card'] = tem1;
                                break;
                        }
                        this.album_template_data.push(tem);
                    }
                    pointer+=max_number;
                }
                console.log(this.album_template_data);
            },
        },
        mounted() {
            this.getFavoriteGoods();      // 加载收藏商品

            this.getTemplate(); // 请求模板
        },
        filters: {
            commission_rate: (value) => {
                if (!value) return '';
                value = value * 1000000 / 10000; // 解决精度问题
                return `${value}%`;
            },
            commission_earnings: (value, price) => {
                if (!value) return '';
                let earnings = (price * value).toFixed(1);
                earnings = Number(earnings);
                return `${earnings}`;
            },
            price: (value)=> {
                return value / 100;
            }
        },
        watch: {
            generateGoodsData: function (val){
                this.articleAmount = Math.ceil(val.length / 3);
            },
        }
    });
</script>