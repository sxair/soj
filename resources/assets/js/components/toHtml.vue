<template>
    <span :style="{color: color}">{{ content }}</span>
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
                color: '',
                content: ''
            }
        },
        mounted() {
            let arg = this.arg;
            if(this.type) {
                let color = [
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
                ];
                let status = [
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
                ];
                if(arg > 10000) arg = parseInt(arg / 10000);
                this.color = color[arg];
                this.content = status[arg];
            } else {
                if (arg <= 0 || arg >= 4) arg = 1;
                let lang = [
                    'c',
                    'c++',
                    'java',
                    'python3',
                ];
                this.content = lang[arg];
            }
        }
    }
</script>