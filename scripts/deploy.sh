#!/bin/bash

PROJECT_FILES=("../server/*")
read -p "netid: " netid

server_project_path="/home/ugrads/${netid:0:1}/$netid/web_project/p1"
hostname=$netid"@unix.cse.tamu.edu"
fullpath=$hostname":"$server_project_path

echo "Removing Old Files: $server_project_path"
ssh $hostname "rm -rf $server_project_path; mkdir $server_project_path"

echo "Moving files to server: $server_project_path"
scp $PROJECT_FILES "$fullpath"
