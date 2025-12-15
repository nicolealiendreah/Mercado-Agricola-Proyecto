# Configuración del Proxy Externo

## ⚠️ IMPORTANTE: Configurar el Proxy Reverso

Si estás usando un proxy reverso externo (nginx, Apache, Cloudflare, etc.) delante del contenedor Docker, **DEBES configurar también ese proxy** para permitir archivos grandes.

## Para Nginx como Proxy Externo

Si tienes un nginx en el host que hace proxy a `agrovida-nginx`, agrega esta configuración:

```nginx
server {
    listen 80;
    server_name mercado.dasalas.shop;

    # 🔥 PERMITE SUBIR ARCHIVOS GRANDES
    client_max_body_size 200M;
    client_body_buffer_size 200M;
    client_body_timeout 300s;
    proxy_read_timeout 300s;
    proxy_connect_timeout 300s;
    proxy_send_timeout 300s;

    location / {
        proxy_pass http://agrovida-nginx:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        # Timeouts para archivos grandes
        proxy_read_timeout 300s;
        proxy_connect_timeout 300s;
        proxy_send_timeout 300s;
    }
}
```

## Para Apache como Proxy Externo

Si usas Apache, agrega en tu configuración virtual host:

```apache
<VirtualHost *:80>
    ServerName mercado.dasalas.shop
    
    # Permitir archivos grandes
    LimitRequestBody 209715200  # 200MB en bytes
    
    ProxyPass / http://agrovida-nginx:80/
    ProxyPassReverse / http://agrovida-nginx:80/
    
    ProxyTimeout 300
</VirtualHost>
```

## Para Cloudflare

Si usas Cloudflare, verifica que no tengas límites en el plan. Los planes gratuitos pueden tener restricciones.

## Pasos para Aplicar

1. **Editar la configuración del proxy externo** (generalmente en `/etc/nginx/sites-available/` o `/etc/nginx/conf.d/`)
2. **Agregar `client_max_body_size 200M;`** en el bloque `server`
3. **Reiniciar nginx**: `sudo systemctl reload nginx` o `sudo nginx -s reload`
4. **Verificar**: `sudo nginx -t`

## Verificar la Configuración

Para verificar qué nginx está respondiendo:

```bash
curl -I http://mercado.dasalas.shop
```

Si ves `nginx/1.29.4`, es el contenedor. Si ves otra versión, es el proxy externo.

