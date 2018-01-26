@extends('layouts.app')
@section('content')
    <nav class="s-navbar-media">
        <a class="s-navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MNNUOJ') }}
        </a>
        <button class="slideout-btn">
            <i class="el-icon-menu" style="font-size: 26px;"></i>
        </button>
    </nav>
    <div class="container">
        <el-card class="help">
            <div slot="header" class="clearfix text-center">
                <h3>测试数据创建api文档</h3>
            </div>
            <div style="font-size: 18px">
                <p>
                    本测试平台使用javaScript编写。javaScript教程：<a href="http://www.runoob.com/js/js-tutorial.html" target="_blank">http://www.runoob.com/js/js-tutorial.html</a>
                </p>
                <p>使用时请注意数据的范围，大概生成10w的数据量需要1s，请依据自己电脑的配置来限制最大值。</p>
                <p>编写时，函数可以按 ctrl 键来获取提示</p>
                <div>
                    <p>已经实现的api：</p>
                    <p>获取随机数/字符：</p>
                    <a href="#getRand">getRand</a>
                    <a href="#getChar">getChar</a>
                    <p>打印：</p>
                    <a href="#p">p</a>&nbsp;&nbsp;&nbsp;
                    <a href="#psp">psp</a>&nbsp;&nbsp;&nbsp;
                    <a href="#pln">pln</a>&nbsp;&nbsp;&nbsp;
                    <p>打印一个数/字符:</p>
                    <a href="#rand">rand</a>&nbsp;&nbsp;&nbsp;
                    <a href="#randsp">randsp</a>&nbsp;&nbsp;&nbsp;
                    <a href="#randln">randln</a>&nbsp;&nbsp;&nbsp;
                    <a href="#char">char</a>&nbsp;&nbsp;&nbsp;
                    <p>打印数组/字符串:</p>
                    <a href="#list">list</a>&nbsp;&nbsp;&nbsp;
                    <a href="#string">string</a>&nbsp;&nbsp;&nbsp;
                    <p>打印图：</p>
                    <a href="#graph">graph</a>&nbsp;&nbsp;&nbsp;
                    <a href="#conn_graph">conn_graph</a>&nbsp;&nbsp;&nbsp;
                </div>
                <h3 id="getRand">getRand</h3>
                <p>获取一个l~r间的随机数，f为保留几位小数</p>
                function getRand(l, r, f = 0) ;
                <h3 id="getChar">getChar</h3>
                返回'a' + l到 'a' + r间的字符,b为是否大写<br/>
                function getChar(l = 1, r = 26, b = false) ;
                <h3 id="p">p</h3>
                <p>打印字符串</p>
                function p(s = '') ;
                <h3 id="psp">psp</h3>
                <p>打印字符串和空格</p>
                function psp(s = '') ;
                <h3 id="pln">pln</h3>
                <p>打印字符串和换行</p>
                function pln(s = '') ;
                <h3 id="rand">rand</h3>
                <p>打印l~r间的随机数，f为保留几位小数</p>
                function rand(l, r, f = 0) ;
                <h3 id="randsp">randsp</h3>
                <p>打印l~r间的随机数和空格，f为保留几位小数</p>
                function randsp(l, r, f = 0) ;
                <h3 id="randln">randln</h3>
                <p>打印l~r间的随机数和换行，f为保留几位小数</p>
                function randln(l, r, f = 0) ;
                <h3 id="char">char</h3>
                <p>打印'a' + l到 'a' + r间的字符,b为是否大写</p>
                function char(l = 1, r = 26, b = false) ;
                <h3 id="list">list</h3>
                <p>打印n个l~r间的随机数和空格，f为保留几位小数</p>
                function list(n, l = 1, r = 10000000, f = 0) ;
                <h3 id="string">string</h3>
                <p>打印长度为n的字符串,l和r为字符范围</p>
                function string(n, l = 1, r = 26) ;
                <h3 id="graph">graph</h3>
                <p>打印n个点e条不重复边的有向图,f为回调函数，是每条边后需要添加的权值</p>
                function graph(n, e, f) ;
                <p>如：没权值： graph(10,10); 有权值：graph(10,10,function(){rand(1, 10000)})</p>
                <h3 id="conn_graph">conn_graph</h3>
                <p>打印n个点e条不重复边的联通有向图,f为回调函数，是每条边后需要添加的权值</p>
                function conn_graph(n, e, f) ;
            </div>
        </el-card>
    </div>
@endsection