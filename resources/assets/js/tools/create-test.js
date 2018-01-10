window.tmpTest = "";

function run() {
    try {
        window.tmpTest = "";
        eval(app.$refs.editor.getValue());
        app.test = window.tmpTest;
    }
    catch (err) {
        app.test = err.toString();
    }
}

function max(a, b) {
    return a > b ? a : b;
}

function min(a, b) {
    return a < b ? a : b;
}

/**
 * 加入test中
 */
function testAdd(s) {
    window.tmpTest += s;
}

/**
 * 加入test中
 */
function p(s = '') {
    testAdd(s);
}

/**
 * 加入test中
 */
function psp(s = '') {
    testAdd(s + ' ');
}

/**
 * 加入test中
 */
function pln(s = '') {
    testAdd(s + '\n');
}

/**
 * 获取一个随机数
 * @param l
 * @param r
 * @param f
 * @returns Number
 */
function getRand(l, r, f = 0) {
    if (r < l) {
        throw "Error: getRand(" + l + ',' + r + ',' + f + ')第二个参数应大于第一个参数';
    }
    var ans = Number((Math.random() * (r - l) + l).toFixed(f));
    if (ans < l || ans > r) {
        throw "Error: getRand(" + l + ',' + r + ',' + f + ')格式错误';
    }
    return ans;
}

/**
 * 打印一个随机数
 * @param l min
 * @param r max
 * @param f 保留几位小数
 */
function rand(l, r, f = 0) {
    testAdd(getRand(l, r, f));
}

/**
 * 打印一个随机数并换行
 * @param l min
 * @param r max
 * @param f 保留几位小数
 */
function randln(l, r, f = 0) {
    testAdd(getRand(l, r, f) + '\n');
}

/**
 * 打印一个随机数和空格
 * @param l min
 * @param r max
 * @param f 保留几位小数
 */
function randsp(l, r, f = 0) {
    testAdd(getRand(l, r, f) + ' ');
}

/**
 * 打乱序列
 * @param arr 数组，从0开始
 * @param n 长度
 */
function random_shuffle(arr, n) {
    for(var i = 0, t, b; i < n; i++) {
        t = arr[i];
        b = (i + getRand(1, n)) % n;
        arr[i] = arr[b];
        arr[b] = t;
    }
}

/**
 * 打印n个随机数
 * @param n
 * @param l min
 * @param r max
 * @param f 保留几位小数
 */
function line(n, l = 1, r = 10000000, f = 0) {
    while (n-- > 0) {
        n === 0 ? randln(l, r) : randsp(l, r);
    }
}

/**
 * 返回'a' + l到 'z' + r间的字符
 * @param l
 * @param r
 * @param b
 */
function getChar(l = 1, r = 26, b = false) {
    return String.fromCharCode(getRand(l, r) + 96 - (b ? 32 : 0));
}

/**
 * 返回'a' + l到 'z' + r间的字符
 * @param l
 * @param r
 * @param b
 */
function char(l = 1, r = 26, b = false) {
    return p(getChar(l, r, b));
}

/**
 * 打印长度为n的字符串
 * @param n
 * @param l
 * @param r
 */
function string(n, l = 1, r = 26) {
    while (n-- > 0) {
        n === 0 ? pln(getChar(l, r)) : p(getChar(l, r));
    }
}

/**
 * 控制需要后接函数的格式
 * @param s
 * @param f
 */
function fun_out(s, f) {
    if (f !== undefined) {
        psp(s);
        f();
        pln();
    } else {
        pln(s);
    }
}

/**
 * 检查有向图的点和边是否符合
 * @param n
 * @param e
 */
function check_graph(n, e) {
    if (e > n * (n - 1)) {
        throw "Error: graph(" + n + ',' + e + ')边数过多';
    }
}

/**
 * 输出点对应的边
 * @param a 点
 * @param n 总点数
 * @param e 需要的边数
 * @param f 回调函数，每条边后的参数
 * @param x 已经有的边
 */
function find_rand_path(a, n, e, f, x) {
    var st = getRand(1, n), tn = n;
    while (e-- > 0) {
        while (st === a || st === x) st++;
        if (st > n) st -= n;
        psp(a);
        fun_out(st, f);
        var add = getRand(1, max(1, parseInt((tn - 1) / e)));
        tn -= add;
        if (e > 0) st += add;
        if (st > n) st -= n;
    }
}

/**
 * 打印n个点e条不重复边的有向图
 * 点从1-n
 * @param n
 * @param e
 * @param f 回调函数，每条边后的参数
 * @param arr 已有的边
 */
function graph(n, e, f, arr) {
    check_graph(n, e);
    var st = getRand(1, n), tn = n; // st:起始点
    var useful = (n - 1);
    if(arr !== undefined) useful--;
    var all = 0;
    while (e > 0) {
        var ne = getRand(max(1, e - (tn - 1) * useful), min(Math.ceil(e / tn), useful)); //分配到该点的边数
        e -= ne;
        find_rand_path(st, n, ne, f, arr === undefined ? undefined : arr[st]);
        var add = getRand(1, min(2, tn - Math.ceil(e / useful)));
        tn -= add;
        if (e > 0) st += add;
        if (st > n) st -= n;
    }
}

/**
 * 打印n个点e条不重复边的联通有向图
 * 点从1-n
 * @param n
 * @param e
 * @param f 回调函数，每条边后的参数
 */
function conn_graph(n, e, f) {
    check_graph(n, e);
    if(e < n - 1) throw "Error: conn_gragh(" + n + ',' + e + ")边数过少不足以构成有向图";
    var a = new Array(n), t = new Array(n + 1);
    for(var i = 0; i < n; i++) a[i] = i + 1;
    random_shuffle(a, n);
    for(var i = 0; i < n - 1; i++) {
        psp(a[i]);
        fun_out(a[i + 1], f);
        t[a[i]] = a[i + 1];
    }

    graph(n, e - n + 1, f, t);
}


/**
 * 打印一个树，
 * @param n
 * @param d
 * @param w
 */
function tree(n, d = -1, w = -1, f) {

}