<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // if use model-factories while faster
        // but I'm lazy to create model

        DB::table('users')->insert([
            'name' => 'sair',
            'email' => '80976512@qq.com',
            'password' => bcrypt('123123'),
            'locked' => 1,
            'control' => config('soj.admin.all') | 1,
        ]);

        DB::table('user_infos')->insert([
            'id' => '1',
        ]);

        DB::table('admins')->insert([
            'id' => 1,
            'password' => bcrypt('admin'),
            'presenter_name' => 'admin',
            'remark' => 'admin'
        ]);

        DB::table('soj')->insert([
            'name' => 'label',
            'content' => '[
    {"name": "全部问题", "id": 0},
    {"name": "图论", "id": 1000, "son": [
           {"name": "最短路", "id": 1001},
           {"name": "最长路", "id": 1002},
           {"name": "网络流", "id": 1003}
        ]
    },
     {"name": "数论", "id": 2000, "son": [
           {"name": "最短路", "id": 2001},
           {"name": "最长路", "id": 2002},
           {"name": "网络流", "id": 2003}
        ]
    }
]']);

        $content = <<<EOF
<h3 id="problem-description">Problem Description</h3>
<p>Calculate a + b.</p>
<h3 id="input">Input</h3>
<p>The input will consist of a series of pairs of integers a and b,separated by a space, one pair of integers per line.</p>
<h3 id="output">Output</h3>
<p>For each pair of input integers a and b you should output the sum of a and b in one line,and with one line of output for each line in input.</p>
<h3 id="sample-input">Sample Input</h3>
<p>1 5
2 3</p>
<h3 id="sample-output">Sample Output</h3>
<p>6
5</p>
<h3 id="hints">Hints</h3>
<p>C++ code for a+b:</p>
<pre><code class="hljs"><span class="hljs-meta">#<span class="hljs-meta-keyword">include</span> <span class="hljs-meta-string">&lt;iostream&gt;</span></span>
<span class="hljs-keyword">using</span> <span class="hljs-keyword">namespace</span> <span class="hljs-built_in">std</span>;
<span class="hljs-function"><span class="hljs-keyword">int</span> <span class="hljs-title">main</span><span class="hljs-params">()</span>
</span>{
  <span class="hljs-keyword">int</span> a,b;
  <span class="hljs-keyword">while</span> (<span class="hljs-built_in">cin</span>&gt;&gt;a&gt;&gt;b) <span class="hljs-built_in">cout</span>&lt;&lt;a+b&lt;&lt;<span class="hljs-built_in">endl</span>;
  <span class="hljs-keyword">return</span> <span class="hljs-number">0</span>;
}
</code></pre><p>Java code for a+b:</p>
<pre><code class="hljs">import java.util.Scanner;

<span class="hljs-keyword">public</span> <span class="hljs-keyword">class</span> <span class="hljs-title">Main</span>
{
    <span class="hljs-function"><span class="hljs-keyword">public</span> <span class="hljs-keyword">static</span> <span class="hljs-keyword">void</span> <span class="hljs-title">main</span>(<span class="hljs-params">String[] args</span>)
    </span>{
        Scanner scan=<span class="hljs-keyword">new</span> Scanner(System.<span class="hljs-keyword">in</span>);
        <span class="hljs-keyword">while</span>(scan.hasNextInt())
        {
            <span class="hljs-keyword">int</span> a=scan.nextInt();
            <span class="hljs-keyword">int</span> b=scan.nextInt();
            System.<span class="hljs-keyword">out</span>.println(a+b);
        }
    }
}
</code></pre>
EOF;

        for ($i = 0; $i < 200; $i++) {
            $sub = rand(0, 1000);
            $ac = rand(0, 1000);
            if ($sub < $ac) {
                $t = $sub;
                $sub = $ac;
                $ac = $t;
            }
            DB::table('oj_problems')->insert([
                'problem_id' => $i + 1,
                'title' => str_random(10),
                'accepted' => $ac,
                'submitted' => $sub,
            ]);

            $randstatus = rand(1, 11);
            if ($randstatus >= 5) {
                $randstatus *= 10000;
                $randstatus += rand(1, 10);
            }
            if (rand(0, 1)) {
                $user_name = str_random(8);
            } else {
                $user_name = 'sair';
            }
            DB::table('oj_status')->insert([
                'problem_id' => 1000,
                'lang' => rand(1, 4),
                'user_name' => $user_name,
                'status' => $randstatus,
                'time' => rand(0, 1000),
                'memory' => rand(1000, 100000),
                'code_len' => rand(100, 1000),
            ]);

            DB::table('admin_problems')->insert([
                'problem_id' => $i + 1,
                'title' => str_random(10),
                'user_name' => 'admin',
                'public' => rand(0, 1),
                'oj_id' => rand(0, 1) ? 0 : $i + 1000
            ]);

            DB::table('problem_md')->insert([
                'id' => $i + 1,
                'content' => '### Problem Description
aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

### Input
aaaaaaaa
### Output
aaa
### Sample Input
adddddddddd
### Sample Output
asdasd
### Hints
asdasdasdasd'
            ]);

            DB::table('problems')->insert([
                'title' => str_random(10),
                'time_limit' => 1000,
                'memory_limit' => 123123,
                'judge_cnt' => 1,
                'spj' => 0,
                'content' => $content,
                'author' => str_random(10),
                'source' => str_random(10),
            ]);
            DB::table('contests')->insert([
                'title' => str_random(10),
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addHour(rand(1, 20)),
                'user_name' => $user_name
            ]);
        }
    }
}