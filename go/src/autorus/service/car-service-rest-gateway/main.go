package main

import (
  "flag"
  "net/http"
  "github.com/golang/glog"
  "golang.org/x/net/context"
  "github.com/grpc-ecosystem/grpc-gateway/runtime"
  "google.golang.org/grpc"
  "../car-service"
)

var (
  carServiceEndpoint = flag.String("car_service_endpoint", "127.0.0.1:9001", "endpoint of YourService")
)

func run() error {
  ctx := context.Background()
  ctx, cancel := context.WithCancel(ctx)
  defer cancel()

  customMarshaller := &runtime.JSONPb{
    OrigName:     true,
    EmitDefaults: true, // disable 'omitempty'
  }
  muxOpt := runtime.WithMarshalerOption(runtime.MIMEWildcard, customMarshaller)
  mux := runtime.NewServeMux(muxOpt)

  opts := []grpc.DialOption{grpc.WithInsecure()}
  err := CarService.RegisterCarServiceHandlerFromEndpoint(ctx, mux, *carServiceEndpoint, opts)
  if err != nil {
    return err
  }

  return http.ListenAndServe(":3333", mux)
}

func main() {
  flag.Parse()
  defer glog.Flush()

  if err := run(); err != nil {
    glog.Fatal(err)
  }
}
