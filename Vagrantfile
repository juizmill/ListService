# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.provision :shell, :path => "bootstrap.sh"

  config.vm.synced_folder ".", "/vagrant", type: "nfs", mount_options: ['rw', 'vers=3', 'tcp', 'fsc']
  config.vm.network "private_network", ip: "10.0.1.10"
  config.vm.hostname = "listservice.dev"

  config.vm.provider :virtualbox do |virtualbox|
    virtualbox.name = "ListService"
    virtualbox.customize ["modifyvm", :id, "--cpus", "2"]
    virtualbox.customize ["modifyvm", :id, "--ioapic", "on"]
    # allocate max 90% CPU
    virtualbox.customize ["modifyvm", :id, "--cpuexecutioncap", "95"]
    virtualbox.customize ["modifyvm", :id, "--memory", "1700"]
  end

  unless Vagrant.has_plugin?("HostManager")
     puts "--- SUGESTAO ---"
     puts "Que tal digitar no navegador 'localhost.dev' ao invés de 'localhost:3000'?"
     puts "Instale o plugin hostmanager: 'vagrant plugin install vagrant-hostmanager'"
     puts "Visite https://github.com/smdahlen/vagrant-hostmanager para maiores informacoes"
     puts "----------------"
   end

   # configs for vagrant-hostmanager
   if Vagrant.has_plugin?("HostManager")
     config.hostmanager.enabled = true
     config.hostmanager.manage_host = true
     config.hostmanager.ignore_private_ip = false
     config.hostmanager.include_offline = true
     config.hostmanager.aliases = 'listservice.dev'
   end

end
