# Plataforma Web de Venta de Componentes Informáticos con Despliegue Automatizado en AWS EKS

Proyecto de Fin de Grado de Alejandro Cortés Rodríguez.

## Descripción

Este proyecto consiste en el desarrollo e implementación de una plataforma web segura, escalable y automatizada para la venta de componentes informáticos, desplegada completamente en la nube utilizando tecnologías modernas como **Docker**, **Kubernetes (EKS)**, **Terraform**, **Ansible** y **GitHub Actions**.

La arquitectura está diseñada para seguir las mejores prácticas DevOps y ofrecer un entorno de producción confiable y fácilmente escalable.

## Objetivos

- Automatización del despliegue mediante GitHub Actions.
- Contenerización eficiente con Docker.
- Orquestación robusta con Kubernetes en AWS EKS.
- Infraestructura como Código (IaC) con Terraform.
- Seguridad mediante certificados SSL y dominios personalizados.
- Gestión completa del ciclo de vida de la aplicación web (usuarios, productos, pedidos, proveedores, etc.).

## Tecnologías Utilizadas

- **AWS (EKS, EC2, S3, ECR)**
- **Terraform** – Infraestructura como código.
- **Docker** – Creación de contenedores.
- **Ansible** – Automatización de configuración de imágenes Docker.
- **Kubernetes** – Orquestación de contenedores.
- **GitHub Actions** – CI/CD.
- **PHP, HTML, CSS, JS** – Desarrollo frontend/backend.
- **MySQL** – Base de datos relacional.

## Despliegue Automatizado

El proceso está completamente automatizado mediante GitHub Actions en tres fases:

1. **Construcción de imágenes Docker personalizadas** (NGINX, PHP, MySQL).
2. **Despliegue de infraestructura con Terraform**: red, subredes, clúster EKS, instancias, EFS, grupos de seguridad.
3. **Despliegue en Kubernetes**: pods, services, deployments y volúmenes con archivos YAML.

### Seguridad

- Gestión de secretos con GitHub Secrets.
- Certificados SSL integrados.
- Uso de dominios personalizados mediante CNAME.

## Funcionalidades de la Plataforma

- Página responsive para todo tipo de dispositivos.
- Sistema de registro e inicio de sesión con control de roles (admin y usuario).
- Gestión completa de productos (alta, baja, modificación, inventario).
- Gestión de proveedores.
- Carrito de compras e historial de pedidos.
- Administración de usuarios y control de roles.
- Filtros y búsquedas avanzadas.

## Estructura de la Base de Datos

El modelo incluye 5 tablas relacionadas, destacando:

- Carrito con estado (`pendiente` / `pagado`).
- Historial de pedidos por usuario.
- Asociación entre productos y proveedores.

## Acceso

Una vez desplegado, el acceso se realiza desde un dominio personalizado configurado en IONOS vía CNAME apuntando al Load Balancer de AWS EKS.

## Bibliografía

- [Documentación de AWS EKS](https://docs.aws.amazon.com/eks/)
- [Terraform](https://www.terraform.io/docs)
- [Docker Docs](https://docs.docker.com/)
- [Ansible](https://docs.ansible.com/)
- [Kubernetes](https://kubernetes.io/docs/)
- [GitHub Actions](https://docs.github.com/en/actions)
- [MySQL](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/es/)
- [W3Schools PHP](https://www.w3schools.com/php/)

---

 Este proyecto representa una solución moderna, automatizada y alineada con el ecosistema DevOps para una tienda online, preparada para evolucionar e integrarse con servicios empresariales reales (métodos de pago, MFA, analítica, etc.).

