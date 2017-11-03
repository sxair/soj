<template>
    <nav class="s-navbar" id="menu">
        <div class="container">
            <a class="s-navbar-brand s-mhidden" href="/">
                {{ title }}
            </a>
            <ul class="s-nav">
                <li><a href="/problems">Problems</a></li>
                <li><a href="#">Contests</a></li>
            </ul>
            <ul class="s-nav s-nav-right">
                <li v-if="!user.id"><a href="/login">Login</a></li>
                <li v-if="!user.id"><a href="/register">Register</a></li>
                <li v-if="user.id">
                    <a href="#" class="dropdown-toggle">
                        {{ user.name }}
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a :href="userUrl">个人信息</a>
                            <a href="/change">修改资料</a>
                            <a href="/control">功能管理</a>
                            <a href="/logout"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="/logout" method="POST"
                                  style="display: none;">
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
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
            user: {
                type: Object,
                default: function () {
                    return { id: 0, name: '', control: 0 }
                }
            }
        },
        computed: {
            userUrl: function () {
                return "/userinfo/" + this.user.name;
            }
        }
    }
</script>