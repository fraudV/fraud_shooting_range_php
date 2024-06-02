import requests
import time

while True:
    time.sleep(60)
    try:
        req = requests.get('http://php/content.php?page=1&limit=10&userRobot=fraud', timeout=5)
        rj = req.json()
        if len(rj['data'])<=0:
                continue
        data = {
            'password': 'wSf2sxk88eF3kliLGYwQIXSmxDswbVdc',
            'confirmPassword': 'wSf2sxk88eF3kliLGYwQIXSmxDswbVdc'
        }
        requests.post(rj['data'][0]['content'].split('：')[1], data=data, timeout=5)
    except Exception  as e:
        print(f"请求失败: {e}")