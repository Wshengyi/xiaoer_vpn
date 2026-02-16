from fastapi import APIRouter

router = APIRouter()


@router.get('/health')
def health_check():
    return {'status': 'ok', 'service': 'xiaoer_vpn_api'}


@router.get('/v1/site/meta')
def site_meta():
    return {
        'name_cn': '小二VPN',
        'name_en': 'xiaoer_vpn',
        'domain': 'vpn.firstdemo.cn',
        'stage': 'mvp'
    }
