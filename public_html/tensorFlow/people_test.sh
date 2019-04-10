#sh people_test.sh

python3 label_image1.py --graph=people_output_graph.pb --labels=people_output_labels.txt --input_layer=Placeholder --output_layer=final_result --image=../UserImg/test/*.png