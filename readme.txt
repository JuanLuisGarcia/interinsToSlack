Guía de instalación:

Clonar el repositorio, según el S.O:
	Windows: C:/champp/htdocs
	Linux: var/www

Cambiar la url de:  interinos/application/libraries/parser line: 10

Esa linea se sustituye por la que nos proporcione slack, siguiendo los pasos indicados en la siguiente dirección: https://slack.com/apps/A0F7XDUAZ-incoming-webhooks


Al ser una aplicación que unicamente se ejecuta en el backend, la interfaz visual para recibir el feedback es el propio slack. Por lo tanto, para ver el resultado de la ejecución es necesario estar logueado en dicha aplicación.