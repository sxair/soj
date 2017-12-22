<div>
    <p>亲爱的用户{{ $data->name }}，恭喜您被{{ $data->presenter_name }}升级为{{ config('soj.admin_name')[$data->type] }}</p>
    <p>管理密码初始为{{ $data->passwork }},请尽快进入系统后台进行更改</p>
</div>