provider "azurerm" {
  features {}
}

resource "azurerm_resource_group" "main" {
  name     = "${var.prefix}-resources"
  location = "francecentral"
}

resource "azurerm_virtual_network" "main" {
  name                = "${var.prefix}-network"
  address_space       = ["10.0.0.0/16"]
  location            = azurerm_resource_group.main.location
  resource_group_name = azurerm_resource_group.main.name
}

resource "azurerm_subnet" "internal" {
  name                 = "internal"
  resource_group_name  = azurerm_resource_group.main.name
  virtual_network_name = azurerm_virtual_network.main.name
  address_prefixes     = ["10.0.2.0/24"]
}

resource "azurerm_public_ip" "pip" {
  name                = "${var.prefix}-pip"
  resource_group_name = azurerm_resource_group.main.name
  location            = azurerm_resource_group.main.location
  allocation_method   = "Static"
}

resource "azurerm_network_interface" "primary" {
  name                = "${var.prefix}-nic1"
  resource_group_name = azurerm_resource_group.main.name
  location            = azurerm_resource_group.main.location

  ip_configuration {
    name                          = "primary"
    subnet_id                     = azurerm_subnet.internal.id
    private_ip_address_allocation = "Dynamic"
    public_ip_address_id          = azurerm_public_ip.pip.id
  }
}

resource "azurerm_network_interface" "internal" {
  name                = "${var.prefix}-nic2"
  resource_group_name = azurerm_resource_group.main.name
  location            = azurerm_resource_group.main.location

  ip_configuration {
    name                          = "internal"
    subnet_id                     = azurerm_subnet.internal.id
    private_ip_address_allocation = "Dynamic"
  }
}

resource "azurerm_network_security_group" "main" {
  name                = "${var.prefix}-nsg"
  location            = azurerm_resource_group.main.location
  resource_group_name = azurerm_resource_group.main.name
  security_rule {
    access                     = "Allow"
    direction                  = "Inbound"
    name                       = "ssh"
    priority                   = 101
    protocol                   = "Tcp"
    source_port_range          = "*"
    source_address_prefix      = "*"
    destination_port_range     = "22"
    destination_address_prefix = azurerm_network_interface.primary.private_ip_address
  }
}

resource "azurerm_network_interface_security_group_association" "main" {
  network_interface_id      = azurerm_network_interface.primary.id
  network_security_group_id = azurerm_network_security_group.main.id
}

resource "azurerm_linux_virtual_machine" "main" {
  name                            = "${var.prefix}-vm"
  resource_group_name             = azurerm_resource_group.main.name
  location                        = azurerm_resource_group.main.location
  size                            = "Standard_B1S"
  admin_username                  = "azureuser"
  admin_password                  = "P@ssw0rd1234!"
  disable_password_authentication = false
  network_interface_ids = [
    azurerm_network_interface.primary.id,
    azurerm_network_interface.internal.id
  ]

  source_image_reference {
    publisher = "Debian"
    offer     = "debian-11"
    sku       = "11-backports-gen2"
    version   = "latest"
  }

  os_disk {
    storage_account_type = "Premium_LRS"
    caching              = "ReadWrite"
  }

  admin_ssh_key {
    username   = "azureuser"
    public_key = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDT4IzZhLlhJAe4OW5ECleod9Q29CxVulDmZadiInOFavInlKO1l4Qrp6DJm79OIHyb4IkE/iNdH/QKu+2b/7qWQ+as3fjWSkYH7XS/IX03bcApbNZp20z4/sL+he9WARxzRVio0z5Zb862/RDmC5SkH/Ana1OXTiv223FfHFbX7DPB6mAaH6cbS7zr4dfiwrYSjbJzFCyI6/RTC6ItmbaTWin3u32xwtLnJV0BhKEvwYsnADxiwDqdgW2+wqMBOpS8uNIoCtXPTB+JplKYPcjxyEsvn+YbaPKDmbZgIJM7+eT1jcAVluU8q277SY8hdxxYfxhVYfNoxDDhfnwjbo01NgyHEPXi7dLirf5/UNsT8C1Uw/CzuKsbJvBTzbYyI1Te1Dig8XgNSOR7HxC9VWKLvGhTUgBmAn91drn/s3bffNTF9EaxK23DRy6iCxt3qN11a/v7IataTd9ZBwtWY6X0CfX2mPqFoixl/1rql0yzae8g/Ti1AdTl2Tu6iwN8BPs= pmbjojo@xps"
  }
}