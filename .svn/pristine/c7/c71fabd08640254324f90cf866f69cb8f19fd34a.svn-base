<script>
    // 添加响应拦截器
    axios.interceptors.response.use(function (response) {
        // 对响应数据做点什么
        return response;
    }, function (error) {
        // 对响应错误做点什么
        axiosThis.$Message.error('服务器开了点小差~');
        axiosThis.$Spin.hide();
        console.log(error);
        return Promise.reject(error);
    });

    // 事件总线 - 用于组件间事件通信
    let bus = new Vue();

    // Vuex
    const store = new Vuex.Store({
        state: {
            goodsSelect: [], // 商品卡已选商品
            goodsGroup: [],  // 用户分组数据
            categories: [],  // 三级分类数据
            temaiGoodsSearchConfig:[], // 自有店铺搜索
            commonUrlV1: 'https://baseinfo.youdnr.com/api/goods/get_goods_data_v1_2', // 公共库 URL
            commonUrlV2: 'https://baseinfo.youdnr.com/api/goods/get_goods_data_v2', // 公共库 URL
            commonUrlGetGoodsAmount: 'https://baseinfo.youdnr.com/api/goods/get_goods_amount', // 找同款使用
            commonTagUpdate: 'https://baseinfo.youdnr.com/api/goods/update_goods_tags', // 商品标签
            commonTagGet: 'https://baseinfo.youdnr.com/api/goods/get_goods_tags', // 商品标签
            page: { // 全局分页配置
                limit: 78, //分页大小
            }
        },
        mutations: {
            addCategories (state, categories) { // 添加三级分类数据
                state.categories = categories;
            },
            addGoodsSelect (state, goods) { // 添加已选商品
                state.goodsSelect.push(goods);
            },
            delGoodsSelect (state, index) { // 删除已选商品
                state.goodsSelect.splice(index,1);
            },
            delAllGoodsSelect (state) { // 删除全部已选商品
                state.goodsSelect = [];
            },
            getGoodsGroup (state) { // 获取分组
                axios.get("{{ route('goods_group/get_goods_group') }}").then(function (response) {
                    state.goodsGroup = response.data;
                });
            },
            syncGoodsSelectOrder(state, goodsSelect) {
                state.goodsSelect = goodsSelect;
            },
            getShopConfig(state, shop){
                state.temaiGoodsSearchConfig = shop;
            }
        },
        getters: {
            commission_rate: (state) => (value) => { // 格式化商品金额
                if (!value) return '';
                value = value * 1000000 / 10000;
                return `${value}%`;
            },
            commission_earnings: (state) => (value, price) => { // 格式化预估收入
                if (!value) return '';
                let earnings = (price * value).toFixed(1);
                earnings = Number(earnings);
                return `${earnings}`;
            },
            syncGoodsSelectStyle: (state) => (goodsData) => { // 同步已选商品页面展示状态
                goodsData.map(item=>{
                    item.status = false;
                });

                if(state.goodsSelect.length < 1) return goodsData;

                for(let goods of goodsData){
                    for(let select of state.goodsSelect){
                        if(goods.id === select.id){
                            goods.status = true;
                            break;
                        }
                    }
                }
                return goodsData;
            }
        }
    });
</script>