/*
 * NB:  This file is machine generated, DO NOT EDIT!
 *
 * Edit and run generate.py instead
 */

VCL_HTTP VRT_r_bereq(VRT_CTX);

VCL_BACKEND VRT_r_bereq_backend(VRT_CTX);
void VRT_l_bereq_backend(VRT_CTX, VCL_BACKEND);

VCL_DURATION VRT_r_bereq_between_bytes_timeout(VRT_CTX);
void VRT_l_bereq_between_bytes_timeout(VRT_CTX, VCL_DURATION);

VCL_DURATION VRT_r_bereq_connect_timeout(VRT_CTX);
void VRT_l_bereq_connect_timeout(VRT_CTX, VCL_DURATION);

VCL_DURATION VRT_r_bereq_first_byte_timeout(VRT_CTX);
void VRT_l_bereq_first_byte_timeout(VRT_CTX, VCL_DURATION);


VCL_STRING VRT_r_bereq_method(VRT_CTX);
void VRT_l_bereq_method(VRT_CTX, const char *, ...);

VCL_STRING VRT_r_bereq_proto(VRT_CTX);
void VRT_l_bereq_proto(VRT_CTX, const char *, ...);

VCL_INT VRT_r_bereq_retries(VRT_CTX);

VCL_BOOL VRT_r_bereq_uncacheable(VRT_CTX);

VCL_STRING VRT_r_bereq_url(VRT_CTX);
void VRT_l_bereq_url(VRT_CTX, const char *, ...);

VCL_STRING VRT_r_bereq_xid(VRT_CTX);

VCL_HTTP VRT_r_beresp(VRT_CTX);

VCL_DURATION VRT_r_beresp_age(VRT_CTX);

VCL_BACKEND VRT_r_beresp_backend(VRT_CTX);

VCL_IP VRT_r_beresp_backend_ip(VRT_CTX);

VCL_STRING VRT_r_beresp_backend_name(VRT_CTX);

VCL_BOOL VRT_r_beresp_do_esi(VRT_CTX);
void VRT_l_beresp_do_esi(VRT_CTX, VCL_BOOL);

VCL_BOOL VRT_r_beresp_do_gunzip(VRT_CTX);
void VRT_l_beresp_do_gunzip(VRT_CTX, VCL_BOOL);

VCL_BOOL VRT_r_beresp_do_gzip(VRT_CTX);
void VRT_l_beresp_do_gzip(VRT_CTX, VCL_BOOL);

VCL_BOOL VRT_r_beresp_do_stream(VRT_CTX);
void VRT_l_beresp_do_stream(VRT_CTX, VCL_BOOL);

VCL_DURATION VRT_r_beresp_grace(VRT_CTX);
void VRT_l_beresp_grace(VRT_CTX, VCL_DURATION);


VCL_DURATION VRT_r_beresp_keep(VRT_CTX);
void VRT_l_beresp_keep(VRT_CTX, VCL_DURATION);

VCL_STRING VRT_r_beresp_proto(VRT_CTX);
void VRT_l_beresp_proto(VRT_CTX, const char *, ...);

VCL_STRING VRT_r_beresp_reason(VRT_CTX);
void VRT_l_beresp_reason(VRT_CTX, const char *, ...);

VCL_INT VRT_r_beresp_status(VRT_CTX);
void VRT_l_beresp_status(VRT_CTX, VCL_INT);

VCL_STRING VRT_r_beresp_storage_hint(VRT_CTX);
void VRT_l_beresp_storage_hint(VRT_CTX, const char *, ...);

VCL_DURATION VRT_r_beresp_ttl(VRT_CTX);
void VRT_l_beresp_ttl(VRT_CTX, VCL_DURATION);

VCL_BOOL VRT_r_beresp_uncacheable(VRT_CTX);
void VRT_l_beresp_uncacheable(VRT_CTX, VCL_BOOL);

VCL_BOOL VRT_r_beresp_was_304(VRT_CTX);

VCL_STRING VRT_r_client_identity(VRT_CTX);
void VRT_l_client_identity(VRT_CTX, const char *, ...);

VCL_IP VRT_r_client_ip(VRT_CTX);

VCL_IP VRT_r_local_ip(VRT_CTX);

VCL_TIME VRT_r_now(VRT_CTX);

VCL_DURATION VRT_r_obj_age(VRT_CTX);

VCL_DURATION VRT_r_obj_grace(VRT_CTX);

VCL_INT VRT_r_obj_hits(VRT_CTX);


VCL_DURATION VRT_r_obj_keep(VRT_CTX);

VCL_STRING VRT_r_obj_proto(VRT_CTX);

VCL_STRING VRT_r_obj_reason(VRT_CTX);

VCL_INT VRT_r_obj_status(VRT_CTX);

VCL_DURATION VRT_r_obj_ttl(VRT_CTX);

VCL_BOOL VRT_r_obj_uncacheable(VRT_CTX);

VCL_IP VRT_r_remote_ip(VRT_CTX);

VCL_HTTP VRT_r_req(VRT_CTX);

VCL_BACKEND VRT_r_req_backend_hint(VRT_CTX);
void VRT_l_req_backend_hint(VRT_CTX, VCL_BACKEND);

VCL_BOOL VRT_r_req_can_gzip(VRT_CTX);

VCL_BOOL VRT_r_req_esi(VRT_CTX);
void VRT_l_req_esi(VRT_CTX, VCL_BOOL);

VCL_INT VRT_r_req_esi_level(VRT_CTX);

VCL_BOOL VRT_r_req_hash_always_miss(VRT_CTX);
void VRT_l_req_hash_always_miss(VRT_CTX, VCL_BOOL);

VCL_BOOL VRT_r_req_hash_ignore_busy(VRT_CTX);
void VRT_l_req_hash_ignore_busy(VRT_CTX, VCL_BOOL);


VCL_STRING VRT_r_req_method(VRT_CTX);
void VRT_l_req_method(VRT_CTX, const char *, ...);

VCL_STRING VRT_r_req_proto(VRT_CTX);
void VRT_l_req_proto(VRT_CTX, const char *, ...);

VCL_INT VRT_r_req_restarts(VRT_CTX);

VCL_DURATION VRT_r_req_ttl(VRT_CTX);
void VRT_l_req_ttl(VRT_CTX, VCL_DURATION);

VCL_STRING VRT_r_req_url(VRT_CTX);
void VRT_l_req_url(VRT_CTX, const char *, ...);

VCL_STRING VRT_r_req_xid(VRT_CTX);


VCL_STRING VRT_r_req_top_method(VRT_CTX);

VCL_STRING VRT_r_req_top_proto(VRT_CTX);

VCL_STRING VRT_r_req_top_url(VRT_CTX);

VCL_HTTP VRT_r_resp(VRT_CTX);


VCL_BOOL VRT_r_resp_is_streaming(VRT_CTX);

VCL_STRING VRT_r_resp_proto(VRT_CTX);
void VRT_l_resp_proto(VRT_CTX, const char *, ...);

VCL_STRING VRT_r_resp_reason(VRT_CTX);
void VRT_l_resp_reason(VRT_CTX, const char *, ...);

VCL_INT VRT_r_resp_status(VRT_CTX);
void VRT_l_resp_status(VRT_CTX, VCL_INT);

VCL_STRING VRT_r_server_hostname(VRT_CTX);

VCL_STRING VRT_r_server_identity(VRT_CTX);

VCL_IP VRT_r_server_ip(VRT_CTX);

double VRT_Stv_free_space(const char *);
double VRT_Stv_used_space(const char *);
unsigned VRT_Stv_happy(const char *);
