import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    vus: 1,
    duration: '10s',

    thresholds: {
        http_req_failed: ['rate<0.01'],
        http_req_duration: ['p(95)<3000'],
        checks: ['rate>0.99'],
    },
};

export default function () {
    const response = http.get('http://proyecto_integrador.test/login', {
        tags: {
            name: 'GET /login',
            scenario: 'login_publico',
        },
    });

    check(response, {
        'respuesta HTTP 200': (res) => res.status === 200,
        'pagina contiene formulario': (res) =>
            res.body.includes('<form'),
        'pagina contiene campo password': (res) =>
            res.body.includes('type="password"'),
    });

    sleep(1);
}