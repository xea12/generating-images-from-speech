#!/bin/bash

# Nazwa pliku obrazu
image_file="generated_image.jpg"

# Sprawdzenie, czy istnieje folder "image"
if [ -d "image" ]; then
    # Sprawdzenie, czy istnieje plik obrazu
    if [ -f "image/$image_file" ]; then
        lp -d XP-3100 -o scaling=80 image/$image_file
    else
        echo "Plik '$image_file' nie istnieje w folderze 'image'."
    fi
else
    echo "Folder 'image' nie istnieje."
fi
