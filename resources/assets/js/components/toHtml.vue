<template>
    <span :style="{color: scolor}">{{ content }}</span>
</template>
<script>
    export default {
        props: {
            type: {
                type: Number,
                default: 0
            },
            arg: {
                type: Number,
                default: 0
            }
        },
        data() {
            return {
                statusColor: [
                    'rgb(102,153,0)',
                    'green',
                    'rgb(26, 174, 0)',
                    'red',
                    'rgb(6, 146, 255)',
                    'rgb(153, 153, 153)',
                    'rgb(255, 153, 0)',
                    'rgb(255, 3, 250)',
                    'blue',
                    'rgb(187, 51, 143)',
                    'rgb(187, 51, 143)',
                    'rgb(187, 51, 143)',
                    'rgb(187, 51, 143)',
                    'rgb(187, 51, 143)',
                    'rgb(187, 51, 143)',
                ],
                status: [
                    'Queuing',
                    'Compiling',
                    'Compilation error',
                    'Accepted',
                    'System Error',
                    /*base of test_max*/
                    'Running',
                    'Wrong Answer',
                    'Memory Limit Exceeded',
                    'Output Limit Exceeded',
                    'Time Limit Exceeded',
                    'Presentation Error',
                    'Runtime Error',
                    'Runtime Error</br>(Segmentation fault)',
                    'Runtime Error</br>(Floating Point Exception)',
                    'Runtime Error</br>(NOT ALLOWED SYSTEM CALL)',
                ],
                lang: [
                    'c',
                    'c++',
                    'java',
                    'python2',
                    'python3',
                ]
            }
        },
        computed:{
            scolor: function () {
                if(this.type == 0) return "";
                let arg = this.arg;
                if(arg > 10000) arg = parseInt(arg / 10000);
                return this.statusColor[arg];
            },
            content: function () {
                if(this.type == 1) {
                    let arg = this.arg;
                    if(arg > 10000) arg = parseInt(arg / 10000);
                    return this.status[arg];
                }
                if (this.arg <= 0 || this.arg > 5) this.arg = 1;
                return this.lang[this.arg - 1];
            }
        },
    }
</script>