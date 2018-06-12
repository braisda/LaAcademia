#!/bin/sh
echo "\n	########## INICIANDO INSTALACIÓN 'LA ACADEMIA' ##########"
echo "\nCambiando directorio a /var/www/html..."
cd /var/www/html
echo "\nDescargando 'LaAcademia'...\n"
git clone "https://github.com/braisda/LaAcademia.git"
cd LaAcademia
echo "\nDescarga finalizada"
echo "\nConfigurando permisos..."
chmod 777 -R multimedia
echo "\nPermisos configurados correctamente"
echo "\n"
echo " #                   #     #####     #    ######  ####### #     # ###    #"
echo " #         ##       # #   #     #   # #   #     # #       ##   ##  #    # #"
echo " #        #  #     #   #  #        #   #  #     # #       # # # #  #   #   #"
echo " #       #    #   #     # #       #     # #     # #####   #  #  #  #  #     #"
echo " #       ######   ####### #       ####### #     # #       #     #  #  ####### "
echo " #       #    #   #     # #     # #     # #     # #       #     #  #  #     #"
echo " ####### #    #   #     #  #####  #     # ######  ####### #     # ### #     #"
echo "\n	########## INSTALACIÓN FINALIZADA  ##########"
echo "\nAcceda a la aplicación con su navegador desde: 'ip_servidor/LaAcademia'"
echo "\n"
