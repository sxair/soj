<template>
    <div>
        <nav class="s-subbar">
            <div class="s-subcon">
                <ul class="s-subnav">
                    <li><router-link to="/problems">{{ $t('problems') }}</router-link></li>
                    <li><router-link to="/status">{{ $t('status') }}</router-link></li>
                    <li><router-link to="/rank">{{ $t('rank') }}</router-link></li>
                </ul>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>