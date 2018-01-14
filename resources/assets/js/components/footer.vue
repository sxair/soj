<template>
    <footer class="text-center" style="padding:30px 50px">
        <div>
            Copyright © 2017 sair. All rights reserved.
            <el-button type="text" v-if="lang != 0" @click="changeLang(0)">中文</el-button>
            <el-button type="text" v-else disabled>中文</el-button>
            /
            <el-button type="text" v-if="lang != 1" @click="changeLang(1)">English</el-button>
            <el-button type="text" v-else disabled>English</el-button>
        </div>
    </footer>
</template>
<script>
    export default {
        data() {
            return {
                lang: 1
            }
        },
        mounted() {
            this.setLang();
        },
        methods: {
            //设置cookie
            setCookie: function (cname, cvalue, exdays) {
                let d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + "; " + expires;
            },
            //获取cookie
            getCookie: function (cname) {
                let name = cname + "=";
                let ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1);
                    if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
                }
                return undefined;
            },
            setLang() {
                this.lang = this.getCookie('langType');
                if (this.lang == 1 || this.lang === undefined) {
                    this.$i18n.locale = 'en';
                } else if(this.lang == 0){
                    this.$i18n.locale = 'cn';
                } else {
                    this.$i18n.locale = 'en';
                }
            },
            changeLang(t) {
                toTop();
                this.setCookie("langType", t, 1);
                this.setLang();
            }
        }
    }
</script>