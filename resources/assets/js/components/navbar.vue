<template>
    <nav class="s-navbar" id="menu">
        <div class="container">
            <a class="s-navbar-brand s-mhidden" href="/">
                {{ title }}
            </a>
            <div class="s-navfix">
                <ul class="s-nav">
                    <li><a href="/problems">Problems</a></li>
                    <li><a href="/contests">Contests</a></li>
                </ul>
                <ul class="s-nav s-nav-right">
                    <li v-if="!user.id"><a href="/login">Login</a></li>
                    <li v-if="!user.id"><a href="/register">Register</a></li>
                    <li v-if="user.id"
                        @mouseenter="openMenu"
                        @mouseleave="closeMenu"
                        style="position: relative"
                    >
                        <a :href="userinfo">
                            {{ user.name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" :style="{ display : showMenu }">
                            <li>
                                <a href="/change">修改资料</a>
                                <a v-if="user.control & 1" href="/admin">
                                    后台管理
                                </a>
                                <a href="/logout"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    退出
                                </a>
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    <input type="hidden" name="_token"
                                           :value="csrf">
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'MNNUOJ'
            },
        },
        data() {
            return {
                showMenu: 'none',
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },
        computed: {
            userinfo() {
                return "/userinfo/" + this.user.name;
            }
        },
        methods: {
            openMenu() {
                this.showMenu = '';
            },
            closeMenu() {
                this.showMenu = 'none';
            },
        }
    }
</script>