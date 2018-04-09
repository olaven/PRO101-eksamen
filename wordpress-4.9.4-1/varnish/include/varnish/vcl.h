/*
 * NB:  This file is machine generated, DO NOT EDIT!
 *
 * Edit and run generate.py instead
 */

struct vrt_ctx;
#define VRT_CTX const struct vrt_ctx *ctx
struct req;
struct busyobj;
struct ws;
struct cli;
struct worker;

enum vcl_event_e {
	VCL_EVENT_LOAD,
	VCL_EVENT_WARM,
	VCL_EVENT_USE,
	VCL_EVENT_COLD,
	VCL_EVENT_DISCARD,
};

typedef int vcl_event_f(VRT_CTX, enum vcl_event_e);
typedef int vcl_init_f(VRT_CTX);
typedef void vcl_fini_f(VRT_CTX);
typedef int vcl_func_f(VRT_CTX);

/* VCL Methods */
#define VCL_MET_RECV			(1U << 1)
#define VCL_MET_PIPE			(1U << 2)
#define VCL_MET_PASS			(1U << 3)
#define VCL_MET_HASH			(1U << 4)
#define VCL_MET_PURGE			(1U << 5)
#define VCL_MET_MISS			(1U << 6)
#define VCL_MET_HIT			(1U << 7)
#define VCL_MET_DELIVER			(1U << 8)
#define VCL_MET_SYNTH			(1U << 9)
#define VCL_MET_BACKEND_FETCH		(1U << 10)
#define VCL_MET_BACKEND_RESPONSE	(1U << 11)
#define VCL_MET_BACKEND_ERROR		(1U << 12)
#define VCL_MET_INIT			(1U << 13)
#define VCL_MET_FINI			(1U << 14)

#define VCL_MET_MAX			15

#define VCL_MET_MASK			0x7fff

/* VCL Returns */
#define VCL_RET_ABANDON			0
#define VCL_RET_DELIVER			1
#define VCL_RET_FAIL			2
#define VCL_RET_FETCH			3
#define VCL_RET_HASH			4
#define VCL_RET_LOOKUP			5
#define VCL_RET_MISS			6
#define VCL_RET_OK			7
#define VCL_RET_PASS			8
#define VCL_RET_PIPE			9
#define VCL_RET_PURGE			10
#define VCL_RET_RESTART			11
#define VCL_RET_RETRY			12
#define VCL_RET_SYNTH			13

#define VCL_RET_MAX			14

struct VCL_conf {
	unsigned			magic;
#define VCL_CONF_MAGIC			0x7406c509	/* from /dev/random */

	struct director			**default_director;
	const struct vrt_backend_probe	*default_probe;
	unsigned			nref;
	struct vrt_ref			*ref;

	unsigned			nsrc;
	const char			**srcname;
	const char			**srcbody;

	vcl_event_f			*event_vcl;
	vcl_func_f	*recv_func;
	vcl_func_f	*pipe_func;
	vcl_func_f	*pass_func;
	vcl_func_f	*hash_func;
	vcl_func_f	*purge_func;
	vcl_func_f	*miss_func;
	vcl_func_f	*hit_func;
	vcl_func_f	*deliver_func;
	vcl_func_f	*synth_func;
	vcl_func_f	*backend_fetch_func;
	vcl_func_f	*backend_response_func;
	vcl_func_f	*backend_error_func;
	vcl_func_f	*init_func;
	vcl_func_f	*fini_func;

};
