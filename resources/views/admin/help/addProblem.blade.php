@extends('layouts.admin')
@section('content')
    <div class="container">
        <el-card class="help" style="font-size: 20px">
            <div slot="header" class="clearfix text-center">
                <h3>新增题目帮助</h3>
            </div>
            <div>
                <h3><a href="#1">题目规范</a></h3>
                <h3><a href="#2">出题后注意事项</a></h3>
            </div>
            <hr/>
            <h3 id="1">题目规范</h3>
            <div>
                <p>内容格式采用markdown形式编写</p>
                <img src="{{ asset('image/help/mdbar.png') }}" alt="">
                <p>工具栏如上</p>
                <p>对应的功能分别为：</p>
                <p>加粗， 斜体，标题，引用，无序列表，有序列表，链接，图片，代码，预览，全屏编写与展示，全屏编写，帮助文档</p>
                <p>通常来说只需按照给定的模板来编写即可</p>
                <ul>markdown部分功能简介：</ul>
                <li>换行： 请注意，普通编写时换行要使用两个回车哦～！</li>
                <li>添加图片： ![图片备注](http://地址)</li>
                <li>预览： 推荐编写时使用全屏编写与展示功能，但要注意要按到文本框里再按删除键，否则会造成浏览器后退！
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;关闭全屏编写与展示功能需要按全屏编写键才能退出全屏</p>
                </li>
                更为具体的教程请看：<a href="https://www.jianshu.com/p/q81RER" target="_blank">https://www.jianshu.com/p/q81RER</a>
            </div>
            <hr/>
            <h3 id="2">出题后注意事项</h3>
            <div>
                出题后您有如下选择可选：
                <li>修改题目内容</li>
                <li>修改测试数据</li>
                <li>使用特殊判断</li>
                <li>添加标签</li>
                <li>下载测试数据</li>
                <p>退出页面后您还可以在后退的 查看题目->找到对应题目->操作 来查看该页面</p>
                <p>对于修改测试数据：可以上传多组测试数据，但请注意 <strong>即使是空的测试数据也要上传对应的空文件！</strong></p>
                <p>制造测试数据您可以采用本系统自带的测试数据制造功能或者使用代码自己制造</p>
                c/c++模板：
                <pre><code class="hljs"><span class="hljs-meta">#<span class="hljs-meta-keyword">include</span><span class="hljs-meta-string">&lt;stdio.h&gt;</span></span>
<span class="hljs-meta">#<span class="hljs-meta-keyword">include</span><span class="hljs-meta-string">&lt;stdlib.h&gt;</span></span>
<span class="hljs-meta">#<span class="hljs-meta-keyword">include</span> <span class="hljs-meta-string">&lt;time.h&gt;</span></span>
<span class="hljs-function"><span class="hljs-keyword">int</span> <span class="hljs-title">maind</span><span class="hljs-params">()</span> </span>{
    freopen(<span class="hljs-string">"out.cpp"</span>, <span class="hljs-string">"w"</span>, <span class="hljs-built_in">stdout</span>); <span class="hljs-comment">//重定向输出到out.cpp中</span>
    srand(time(<span class="hljs-literal">NULL</span>)); <span class="hljs-comment">//设置随机数种子</span>
    <span class="hljs-built_in">printf</span>(<span class="hljs-string">"%d\n"</span>,rand()); <span class="hljs-comment">// x+rand()%(y-x+1)，生成x～y之间的数</span>
    <span class="hljs-keyword">return</span> <span class="hljs-number">0</span>;
}
</code></pre>
                <p>特殊判断：</p>
                <p>特殊判断统一使用c/c++进行编写。提交代码后如果显示accept则代表编译成功，否则请检查代码</p>
                <p>用户代码运行时会读取测试输入</p>
                <p>特殊数据判断程序的运行为：./spj pro_out_path user_out_path</p>
                <p>详情看例子</p>
                <div>
                    <pre><code class="hljs"><span class="hljs-meta">#<span class="hljs-meta-keyword">include</span> <span class="hljs-meta-string">&lt;stdio.h&gt;</span></span>
<span class="hljs-function"><span class="hljs-keyword">int</span> <span class="hljs-title">main</span><span class="hljs-params">(<span class="hljs-keyword">int</span> argc,<span class="hljs-keyword">char</span> *args[])</span> </span>{
    FILE * pro_out=fopen(args[<span class="hljs-number">1</span>],“r”);<span class="hljs-comment">//测试输出</span>
    FILE * user_out=fopen(args[<span class="hljs-number">2</span>],“r”);<span class="hljs-comment">//用户输出</span>
    <span class="hljs-keyword">int</span> ans = <span class="hljs-number">0</span>; <span class="hljs-comment">//返回 0 为 ac，其他数为wa</span>
    <span class="hljs-keyword">int</span> a;
    <span class="hljs-built_in">fscanf</span>(user_out,“%d”,&amp;a);
    fclose(pro_out);
    fclose(user_out);
    <span class="hljs-keyword">return</span> ans; <span class="hljs-comment">// 等同于exit(ans)</span>
}
</code></pre>
                </div>
            </div>
        </el-card>
    </div>
@endsection