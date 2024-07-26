#!/bin/bash

# Obtém uma lista de todas as interfaces veth
interfaces=$(ip link | grep -o 'veth[0-9a-f]*')

# Itera sobre cada interface e remove seus endereços IP
for interface in $interfaces; do
    ip addr flush dev $interface
done