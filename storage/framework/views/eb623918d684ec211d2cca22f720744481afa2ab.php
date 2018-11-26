<script>
    // 反馈组件
    let feedback = {
        template: `
            <span>
                <a @click="modalFeedback = true" style="margin-left: 40px;font-size: 18px">如未找到商品，点此反馈</a>
                <modal title="商品缺失反馈" v-model="modalFeedback" style="position: absolute;" ok-text="提交" @on-ok="feedbackCommit">
                    <i-input type="textarea" v-model="feedbackText" placeholder="请输入商品链接或店铺名" clearable style="margin: 20px 0 20px 10px;width: 490px;"></i-input>
                </modal>
            </span>
        `,
        data() {
            return {
                modalFeedback: false,
                feedbackText: '',
            }
        },
        methods:{
            feedbackCommit () { // 提交反馈
                let that = this;
                if (!this.feedbackText){
                    that.$Message.info('请不要提交空的内容');
                }else {
                    axios.get("<?php echo e(route('omission_goods/submit_goods')); ?>", {
                        params: {
                            url: this.feedbackText
                        }
                    }).then(function (response) {
                        if (response.data.code == 0){
                            that.$Message.success('提交成功')
                        }else {
                            that.$Message.error(response.data.err_msg)
                        }
                    })
                }

            }
        }
    };
</script>