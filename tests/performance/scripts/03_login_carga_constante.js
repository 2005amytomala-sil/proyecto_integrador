import http from 'k6/http';
import { check, sleep } from 'k6';
import { Counter } from 'k6/metrics';

const respuestas4xx = new Counter('respuestas_4xx');
const respuestas5xx = new Counter('respuestas_5xx');
const erroresConexion = new Counter('errores_conexion');

const usuarios = Number(__ENV.VUS || 5);
const duracion = __ENV.DURATION || '30s';

let erroresMostrados = 0;

export const options = {
    vus: usuarios,
    duration: duracion,

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
            scenario: `login_${usuarios}_usuarios`,
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

    if (response.status !== 200 && erroresMostrados < 2) {
        console.error(
            `Fallo con ${usuarios} VUs: status=${response.status}, ` +
            `error=${response.error || 'sin mensaje'}`
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