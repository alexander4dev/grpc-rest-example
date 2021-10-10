protoc -I/usr/local/include \
-I$GOPATH/src/github.com/grpc-ecosystem/grpc-gateway \
-I$GOPATH/src/github.com/grpc-ecosystem/grpc-gateway/third_party/googleapis \
--plugin=protoc-gen-grpc=./go/bin/grpc_php_plugin \
--proto_path=. \
--go_out=plugins=grpc:./build \
--php_out=./build \
--grpc_out=./build \
--php-grpc_out=./build \
--grpc-gateway_out=logtostderr=true:./build \
--swagger_out=logtostderr=true:./build \
./service.proto

sed -i 's/\\GPBMetadata\\ProtocGenSwagger\\Options\\Annotations::initOnce();/\/\/ \\GPBMetadata\\ProtocGenSwagger\\Options\\Annotations::initOnce(); \/\/ kostyl added from build.sh/g' ./build/Autorus/CarService/Grpc/GPBMetadata/Service.php

go build  -o ./build/car-service-rest-gateway ./go/src/autorus/service/car-service-rest-gateway

rsync -r --delete ./build/Autorus/CarService/Grpc ./src/
rsync -r --delete ./build/service.pb.go ./go/src/autorus/service/car-service
rsync -r --delete ./build/service.pb.gw.go ./go/src/autorus/service/car-service
rsync -r --delete ./build/car-service-rest-gateway ./go/bin
