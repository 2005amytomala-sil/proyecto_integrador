import http from 'k6/http';
import { check, sleep } from 'k6';
import { Counter } from 'k6/metrics';

const respuestas4xx = new Counter('respuestas_4xx');
const respuestas5xx = new Counter('respuestas_5xx');
const erroresConexion = new Counter('errores_conexion');

let erroresMostrados = 0;

export const options = {
    stages: [
        { duration: '15s', target: 1 },
        { duration: '20s', target: 5 },
        { duration: '30s', target: 10 },
        { duration: '30s', target: 25 },
        { duration: '15s', target: 0 },
    ],

    thresholds: {
        http_req_failed: ['rate<0.01'],
        http_req_duration: [
            'avg<2000',
            'p(95)<3000',
        ],
        checks: ['rate>0.99'],
    },
};

export default function () {
    const response = http.get('http://proyecto_integrador.test/login', {
        tags: {
            name: 'GET /login',
            scenario: 'login_carga_gradual',
        },
        timeout: '15s',
    });

    if (response.status >= 400 && response.status < 500) {
        respuestas4xx.add(1);
    }

    if (response.status >= 500) {
        respuestas5xx.add(1);
    }

    if (response.status === 0 || response.error) {
        erroresConexion.add(1);
    }

    if (response.status !== 200 && erroresMostrados < 3) {
        console.error(
            `Respuesta fallida: status=${response.status}, ` +
            `error=${response.error || 'sin mensaje'}, ` +
            `body=${String(response.body || '').substring(0, 150)}`
        );

        erroresMostrados++;
    }

    check(response, {
        'respuesta HTTP 200': (res) => res.status === 200,
        'pagina contiene formulario': (res) =>
            String(res.body || '').includes('<form'),
        'pagina contiene campo password': (res) =>
            String(res.body || '').includes('type="password"'),
    });

    sleep(1);
}