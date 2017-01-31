# Files for vagrant

## What is it?

[vagrant](http://vagrantup.com/) is a package which prepares virtual machines for development purposes. It is used to set up fresh environments with the correct configuration ready to start development or testing without the fuss of following a setup checklist in order to get the application running.

To use, install [vagrant](http://vagrantup.com/) and [VirtualBox](http://www.virtualbox.org/), and run the following command from the application root directory:

```shell
$ vagrant up
```

## What files are in here?

The files within this directory are purely for development purposes and help configure the guest machine for the application.

- `nginx_vagrant`

  The configuration for the `nginx` web server on the supplied virtual machine. Configures PHP for the FPM (FastCGI Process Manager) interface and sets up the root directory.
