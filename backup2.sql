-- Adminer 4.8.1 PostgreSQL 11.13 dump

DROP TABLE IF EXISTS "data_testing";
CREATE TABLE "public"."data_testing" (
    "id" integer NOT NULL,
    "jenis_pengadaan" character varying(255),
    "sumber_dana" character varying(255),
    "jenis_kontrak" character varying(255),
    "pokja" character varying(255),
    "pagu" character varying(255),
    CONSTRAINT "data_testing_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "data_testing" ("id", "jenis_pengadaan", "sumber_dana", "jenis_kontrak", "pokja", "pagu") VALUES
(1,	'BARANG',	'APBD',	'LUMSUM',	NULL,	'A'),
(2,	'KONSTRUKSI',	'APBD',	'LUMSUM',	NULL,	'A'),
(3,	'KONSULTASI',	'APBD',	'LUMSUM',	NULL,	'A'),
(4,	'KONSTRUKSI',	'APBD',	'LUMSUM',	NULL,	'B'),
(5,	'KONSULTASI',	'APBN',	'HARGA SATUAN',	NULL,	'A');

DROP TABLE IF EXISTS "data_training";
CREATE TABLE "public"."data_training" (
    "id" integer DEFAULT GENERATED ALWAYS AS IDENTITY NOT NULL,
    "pokja_id" integer,
    "jenis_pengadaan_id" integer,
    "sumber_dana_id" integer,
    "jenis_kontrak_id" integer,
    "pagu_id" integer,
    CONSTRAINT "data_training_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "idx_1fcc43531fa76ec4" ON "public"."data_training" USING btree ("pokja_id");

CREATE INDEX "idx_1fcc4353343b9189" ON "public"."data_training" USING btree ("jenis_pengadaan_id");

CREATE INDEX "idx_1fcc43535c5f347b" ON "public"."data_training" USING btree ("pagu_id");

CREATE INDEX "idx_1fcc4353bb7f56bd" ON "public"."data_training" USING btree ("sumber_dana_id");

CREATE INDEX "idx_1fcc4353c6469e3b" ON "public"."data_training" USING btree ("jenis_kontrak_id");

INSERT INTO "data_training" ("id", "pokja_id", "jenis_pengadaan_id", "sumber_dana_id", "jenis_kontrak_id", "pagu_id") VALUES
(1,	1,	1,	3,	2,	1),
(2,	1,	4,	1,	4,	1),
(3,	1,	3,	2,	2,	1),
(4,	1,	3,	3,	3,	1),
(5,	1,	2,	2,	4,	1),
(6,	1,	4,	1,	3,	1),
(7,	1,	2,	2,	3,	1),
(8,	1,	1,	3,	1,	1),
(9,	1,	1,	1,	1,	1),
(10,	1,	2,	2,	3,	1),
(11,	1,	4,	3,	3,	1),
(12,	1,	3,	1,	3,	1),
(13,	1,	3,	2,	1,	3),
(14,	1,	2,	4,	2,	3),
(15,	1,	4,	3,	3,	1),
(16,	1,	1,	4,	3,	1),
(17,	1,	1,	2,	4,	1),
(18,	1,	4,	4,	3,	1),
(19,	1,	3,	4,	4,	1),
(20,	1,	3,	2,	3,	1),
(21,	1,	1,	4,	1,	1),
(22,	1,	4,	4,	3,	1),
(23,	1,	3,	4,	4,	1),
(24,	1,	2,	3,	3,	3),
(25,	1,	1,	2,	1,	2),
(26,	1,	4,	3,	2,	1),
(27,	1,	2,	2,	4,	3),
(28,	1,	1,	3,	1,	1),
(29,	2,	3,	3,	3,	1),
(30,	2,	1,	3,	2,	1),
(31,	2,	4,	4,	3,	1),
(32,	2,	2,	1,	2,	1),
(33,	2,	4,	2,	4,	1),
(34,	2,	1,	3,	1,	1),
(35,	2,	3,	1,	3,	1),
(36,	2,	2,	4,	4,	1),
(37,	2,	1,	1,	1,	1),
(38,	2,	1,	2,	4,	2),
(39,	2,	4,	2,	1,	2),
(40,	2,	4,	4,	4,	1),
(41,	2,	4,	1,	1,	1),
(42,	2,	3,	4,	4,	1),
(43,	2,	2,	4,	1,	3),
(44,	2,	3,	1,	4,	1),
(45,	2,	1,	2,	4,	1),
(46,	2,	2,	2,	4,	1),
(47,	2,	1,	2,	4,	1),
(48,	2,	1,	1,	3,	1),
(49,	2,	2,	4,	3,	1),
(50,	2,	4,	2,	4,	1),
(51,	2,	1,	4,	4,	1),
(52,	2,	1,	4,	1,	1),
(53,	2,	3,	3,	1,	1),
(54,	2,	2,	4,	3,	1),
(55,	2,	4,	4,	4,	1),
(56,	2,	3,	2,	2,	1),
(57,	3,	2,	1,	2,	1),
(58,	3,	1,	1,	1,	1),
(59,	3,	4,	3,	3,	3),
(60,	3,	2,	1,	2,	1),
(61,	3,	4,	3,	1,	1),
(62,	3,	2,	2,	3,	2),
(63,	3,	1,	4,	1,	1),
(64,	3,	2,	1,	2,	1),
(65,	3,	4,	1,	2,	1),
(66,	3,	3,	2,	3,	1),
(67,	3,	1,	3,	4,	2),
(68,	3,	2,	2,	3,	2),
(69,	3,	3,	3,	4,	2),
(70,	3,	3,	1,	2,	1),
(71,	3,	1,	3,	2,	1),
(72,	3,	2,	1,	4,	1),
(73,	3,	4,	4,	2,	2),
(74,	2,	1,	3,	2,	1),
(75,	3,	3,	1,	2,	1),
(76,	3,	3,	4,	1,	1),
(77,	3,	1,	2,	1,	1),
(78,	3,	2,	2,	2,	1),
(79,	3,	3,	4,	2,	3),
(80,	3,	3,	1,	2,	1),
(81,	4,	1,	1,	1,	2),
(82,	4,	1,	4,	4,	2),
(83,	4,	4,	1,	1,	1),
(84,	4,	2,	2,	2,	1),
(85,	4,	2,	2,	2,	2),
(86,	4,	3,	1,	3,	2),
(87,	4,	2,	2,	2,	1),
(88,	4,	2,	1,	2,	2),
(89,	4,	1,	1,	1,	1),
(90,	4,	4,	4,	1,	1),
(91,	4,	1,	3,	2,	2),
(92,	4,	2,	1,	2,	1),
(93,	4,	2,	1,	4,	2),
(94,	4,	2,	2,	2,	1),
(95,	4,	3,	2,	2,	1),
(96,	4,	3,	4,	4,	2),
(97,	4,	3,	3,	4,	1),
(98,	4,	2,	1,	2,	2),
(99,	4,	2,	1,	4,	1),
(100,	4,	1,	1,	2,	1),
(101,	4,	2,	2,	2,	1),
(102,	4,	1,	2,	1,	1),
(103,	4,	1,	2,	2,	1),
(104,	4,	2,	1,	1,	3);

DROP TABLE IF EXISTS "dt_training";
CREATE TABLE "public"."dt_training" (
    "id" integer DEFAULT GENERATED ALWAYS AS IDENTITY NOT NULL,
    "pokja" character varying(255),
    "jenis_pengadaan" character varying(255),
    "sumber_dana" character varying(255),
    "jenis_kontrak" character varying(255),
    "pagu" character varying(255),
    CONSTRAINT "dt_training_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "dt_training" ("id", "pokja", "jenis_pengadaan", "sumber_dana", "jenis_kontrak", "pagu") VALUES
(1,	'POKJA PEMILIHAN 212',	'BARANG',	'BLUD',	'HARGA SATUAN',	'A'),
(2,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'APBD',	'WAKTU PENUGASAN',	'A'),
(3,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'APBN',	'HARGA SATUAN',	'A'),
(4,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'BLUD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(5,	'POKJA PEMILIHAN 212',	'KONSTRUKSI',	'APBN',	'WAKTU PENUGASAN',	'A'),
(6,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'APBD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(7,	'POKJA PEMILIHAN 212',	'KONSTRUKSI',	'APBN',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(8,	'POKJA PEMILIHAN 212',	'BARANG',	'BLUD',	'LUMSUM',	'A'),
(9,	'POKJA PEMILIHAN 212',	'BARANG',	'APBD',	'LUMSUM',	'A'),
(10,	'POKJA PEMILIHAN 212',	'KONSTRUKSI',	'APBN',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(11,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'BLUD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(12,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'APBD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(13,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'APBN',	'LUMSUM',	'C'),
(14,	'POKJA PEMILIHAN 212',	'KONSTRUKSI',	'LAINNYA',	'HARGA SATUAN',	'C'),
(15,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'BLUD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(16,	'POKJA PEMILIHAN 212',	'BARANG',	'LAINNYA',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(17,	'POKJA PEMILIHAN 212',	'BARANG',	'APBN',	'WAKTU PENUGASAN',	'A'),
(18,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'LAINNYA',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(19,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(20,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'APBN',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(21,	'POKJA PEMILIHAN 212',	'BARANG',	'LAINNYA',	'LUMSUM',	'A'),
(22,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'LAINNYA',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(23,	'POKJA PEMILIHAN 212',	'KONSULTASI',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(24,	'POKJA PEMILIHAN 212',	'KONSTRUKSI',	'BLUD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'C'),
(25,	'POKJA PEMILIHAN 212',	'BARANG',	'APBN',	'LUMSUM',	'B'),
(26,	'POKJA PEMILIHAN 212',	'JASA LAINNYA',	'BLUD',	'HARGA SATUAN',	'A'),
(27,	'POKJA PEMILIHAN 212',	'KONSTRUKSI',	'APBN',	'WAKTU PENUGASAN',	'C'),
(28,	'POKJA PEMILIHAN 212',	'BARANG',	'BLUD',	'LUMSUM',	'A'),
(29,	'POKJA PEMILIHAN 214',	'KONSULTASI',	'BLUD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(30,	'POKJA PEMILIHAN 214',	'BARANG',	'BLUD',	'HARGA SATUAN',	'A'),
(31,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'LAINNYA',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(32,	'POKJA PEMILIHAN 214',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'A'),
(33,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'APBN',	'WAKTU PENUGASAN',	'A'),
(34,	'POKJA PEMILIHAN 214',	'BARANG',	'BLUD',	'LUMSUM',	'A'),
(35,	'POKJA PEMILIHAN 214',	'KONSULTASI',	'APBD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(36,	'POKJA PEMILIHAN 214',	'KONSTRUKSI',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(37,	'POKJA PEMILIHAN 214',	'BARANG',	'APBD',	'LUMSUM',	'A'),
(38,	'POKJA PEMILIHAN 214',	'BARANG',	'APBN',	'WAKTU PENUGASAN',	'B'),
(39,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'APBN',	'LUMSUM',	'B'),
(40,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(41,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'APBD',	'LUMSUM',	'A'),
(42,	'POKJA PEMILIHAN 214',	'KONSULTASI',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(43,	'POKJA PEMILIHAN 214',	'KONSTRUKSI',	'LAINNYA',	'LUMSUM',	'C'),
(44,	'POKJA PEMILIHAN 214',	'KONSULTASI',	'APBD',	'WAKTU PENUGASAN',	'A'),
(45,	'POKJA PEMILIHAN 214',	'BARANG',	'APBN',	'WAKTU PENUGASAN',	'A'),
(46,	'POKJA PEMILIHAN 214',	'KONSTRUKSI',	'APBN',	'WAKTU PENUGASAN',	'A'),
(47,	'POKJA PEMILIHAN 214',	'BARANG',	'APBN',	'WAKTU PENUGASAN',	'A'),
(48,	'POKJA PEMILIHAN 214',	'BARANG',	'APBD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(49,	'POKJA PEMILIHAN 214',	'KONSTRUKSI',	'LAINNYA',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(50,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'APBN',	'WAKTU PENUGASAN',	'A'),
(51,	'POKJA PEMILIHAN 214',	'BARANG',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(52,	'POKJA PEMILIHAN 214',	'BARANG',	'LAINNYA',	'LUMSUM',	'A'),
(53,	'POKJA PEMILIHAN 214',	'KONSULTASI',	'BLUD',	'LUMSUM',	'A'),
(54,	'POKJA PEMILIHAN 214',	'KONSTRUKSI',	'LAINNYA',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(55,	'POKJA PEMILIHAN 214',	'JASA LAINNYA',	'LAINNYA',	'WAKTU PENUGASAN',	'A'),
(56,	'POKJA PEMILIHAN 214',	'KONSULTASI',	'APBN',	'HARGA SATUAN',	'A'),
(57,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'A'),
(58,	'POKJA PEMILIHAN 215',	'BARANG',	'APBD',	'LUMSUM',	'A'),
(59,	'POKJA PEMILIHAN 215',	'JASA LAINNYA',	'BLUD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'C'),
(60,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'A'),
(61,	'POKJA PEMILIHAN 215',	'JASA LAINNYA',	'BLUD',	'LUMSUM',	'A'),
(62,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBN',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'B'),
(63,	'POKJA PEMILIHAN 215',	'BARANG',	'LAINNYA',	'LUMSUM',	'A'),
(64,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'A'),
(65,	'POKJA PEMILIHAN 215',	'JASA LAINNYA',	'APBD',	'HARGA SATUAN',	'A'),
(66,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'APBN',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'A'),
(67,	'POKJA PEMILIHAN 215',	'BARANG',	'BLUD',	'WAKTU PENUGASAN',	'B'),
(68,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBN',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'B'),
(69,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'BLUD',	'WAKTU PENUGASAN',	'B'),
(70,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'APBD',	'HARGA SATUAN',	'A'),
(71,	'POKJA PEMILIHAN 215',	'BARANG',	'BLUD',	'HARGA SATUAN',	'A'),
(72,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBD',	'WAKTU PENUGASAN',	'A'),
(73,	'POKJA PEMILIHAN 215',	'JASA LAINNYA',	'LAINNYA',	'HARGA SATUAN',	'B'),
(74,	'POKJA PEMILIHAN 214',	'BARANG',	'BLUD',	'HARGA SATUAN',	'A'),
(75,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'APBD',	'HARGA SATUAN',	'A'),
(76,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'LAINNYA',	'LUMSUM',	'A'),
(77,	'POKJA PEMILIHAN 215',	'BARANG',	'APBN',	'LUMSUM',	'A'),
(78,	'POKJA PEMILIHAN 215',	'KONSTRUKSI',	'APBN',	'HARGA SATUAN',	'A'),
(79,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'LAINNYA',	'HARGA SATUAN',	'C'),
(80,	'POKJA PEMILIHAN 215',	'KONSULTASI',	'APBD',	'HARGA SATUAN',	'A'),
(81,	'POKJA PEMILIHAN 216',	'BARANG',	'APBD',	'LUMSUM',	'B'),
(82,	'POKJA PEMILIHAN 216',	'BARANG',	'LAINNYA',	'WAKTU PENUGASAN',	'B'),
(83,	'POKJA PEMILIHAN 216',	'JASA LAINNYA',	'APBD',	'LUMSUM',	'A'),
(84,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBN',	'HARGA SATUAN',	'A'),
(85,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBN',	'HARGA SATUAN',	'B'),
(86,	'POKJA PEMILIHAN 216',	'KONSULTASI',	'APBD',	'GABUNGAN LUMSUM DAN HARGA SATUAN',	'B'),
(87,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBN',	'HARGA SATUAN',	'A'),
(88,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'B'),
(89,	'POKJA PEMILIHAN 216',	'BARANG',	'APBD',	'LUMSUM',	'A'),
(90,	'POKJA PEMILIHAN 216',	'JASA LAINNYA',	'LAINNYA',	'LUMSUM',	'A'),
(91,	'POKJA PEMILIHAN 216',	'BARANG',	'BLUD',	'HARGA SATUAN',	'B'),
(92,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'A'),
(93,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBD',	'WAKTU PENUGASAN',	'B'),
(94,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBN',	'HARGA SATUAN',	'A'),
(95,	'POKJA PEMILIHAN 216',	'KONSULTASI',	'APBN',	'HARGA SATUAN',	'A'),
(96,	'POKJA PEMILIHAN 216',	'KONSULTASI',	'LAINNYA',	'WAKTU PENUGASAN',	'B'),
(97,	'POKJA PEMILIHAN 216',	'KONSULTASI',	'BLUD',	'WAKTU PENUGASAN',	'A'),
(98,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBD',	'HARGA SATUAN',	'B'),
(99,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBD',	'WAKTU PENUGASAN',	'A'),
(100,	'POKJA PEMILIHAN 216',	'BARANG',	'APBD',	'HARGA SATUAN',	'A'),
(101,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBN',	'HARGA SATUAN',	'A'),
(102,	'POKJA PEMILIHAN 216',	'BARANG',	'APBN',	'LUMSUM',	'A'),
(103,	'POKJA PEMILIHAN 216',	'BARANG',	'APBN',	'HARGA SATUAN',	'A'),
(104,	'POKJA PEMILIHAN 216',	'KONSTRUKSI',	'APBD',	'LUMSUM',	'C');

DROP TABLE IF EXISTS "jenis_kontrak";
CREATE TABLE "public"."jenis_kontrak" (
    "id" integer NOT NULL,
    "nama_jenis_kontrak" character varying(255) NOT NULL,
    CONSTRAINT "jenis_kontrak_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "jenis_kontrak" ("id", "nama_jenis_kontrak") VALUES
(1,	'LUMSUM'),
(2,	'HARGA SATUAN'),
(3,	'GABUNGAN LUMSUM DAN HARGA SATUAN'),
(4,	'WAKTU PENUGASAN');

DROP TABLE IF EXISTS "jenis_pengadaan";
CREATE TABLE "public"."jenis_pengadaan" (
    "id" integer NOT NULL,
    "nama_jenis_pengadaan" character varying(255) NOT NULL,
    CONSTRAINT "jenis_pengadaan_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "jenis_pengadaan" ("id", "nama_jenis_pengadaan") VALUES
(1,	'BARANG'),
(2,	'KONSTRUKSI'),
(3,	'KONSULTASI'),
(4,	'JASA LAINNYA');

DROP TABLE IF EXISTS "kmj_default_user";
CREATE TABLE "public"."kmj_default_user" (
    "id" uuid NOT NULL,
    CONSTRAINT "kmj_default_user_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON COLUMN "public"."kmj_default_user"."id" IS '(DC2Type:uuid)';

INSERT INTO "kmj_default_user" ("id") VALUES
('1ec99122-5274-6016-965b-01eaa58b7754'),
('1ec99122-58a0-65ca-aecf-01eaa58b7754');

DROP TABLE IF EXISTS "kmj_user";
CREATE TABLE "public"."kmj_user" (
    "id" uuid NOT NULL,
    "username" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "password" character varying(255) NOT NULL,
    "roles" json NOT NULL,
    "is_active" boolean NOT NULL,
    "type" character varying(255) NOT NULL,
    CONSTRAINT "kmj_user_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON COLUMN "public"."kmj_user"."id" IS '(DC2Type:uuid)';

INSERT INTO "kmj_user" ("id", "username", "name", "password", "roles", "is_active", "type") VALUES
('1ec99122-5274-6016-965b-01eaa58b7754',	'root',	'ROOT',	'$2y$13$tYS8hiTPjmuUU24BjrVcR.uQgw5oIvL/wYCFJ70Qp9PeYemK3a.oe',	'["ROLE_SUPER_USER"]',	't',	'defaultuser'),
('1ec99122-58a0-65ca-aecf-01eaa58b7754',	'admin',	'ADMIN',	'$2y$13$3/3pSJWF8JUdPH.5tdiR5Oi.K3d8WKSeT8C2m2W/u9.EjskBuxgEK',	'["ROLE_ADMINISTRATOR"]',	't',	'defaultuser');

DROP TABLE IF EXISTS "my_user";
CREATE TABLE "public"."my_user" (
    "id" uuid NOT NULL,
    "nip" character varying(50) NOT NULL,
    "email" character varying(50) NOT NULL,
    "jabatan" character varying(50) NOT NULL,
    "created_at" timestamp(0) NOT NULL,
    "updated_at" timestamp(0) NOT NULL,
    "no_telp" character varying(50) NOT NULL,
    CONSTRAINT "my_user_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON COLUMN "public"."my_user"."id" IS '(DC2Type:uuid)';


DROP TABLE IF EXISTS "pagu";
CREATE TABLE "public"."pagu" (
    "id" integer NOT NULL,
    "pagu" character varying(255),
    "range_pagu" character varying(255),
    CONSTRAINT "pagu_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "pagu" ("id", "pagu", "range_pagu") VALUES
(1,	'Rp 100.000.000 - Rp 2.000.000.000',	'A'),
(2,	'Rp 2.100.000.000 - Rp 5.000.000.000',	'B'),
(3,	'Rp 5.100.000.000 - Rp 11.000.000.000',	'C');

DROP TABLE IF EXISTS "pokja";
CREATE TABLE "public"."pokja" (
    "id" integer NOT NULL,
    "nama_pokja" character varying(255) NOT NULL,
    "surat_keputusan" character varying(255) NOT NULL,
    "tanggal_sk" date NOT NULL,
    CONSTRAINT "pokja_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "pokja" ("id", "nama_pokja", "surat_keputusan", "tanggal_sk") VALUES
(1,	'POKJA PEMILIHAN 212',	'188/2649/KPTS/022.3/2021',	'2021-07-02'),
(2,	'POKJA PEMILIHAN 214',	'188/2649/KPTS/022.3/2021',	'2021-07-02'),
(3,	'POKJA PEMILIHAN 215',	'188/2649/KPTS/022.3/2021',	'2021-07-02'),
(4,	'POKJA PEMILIHAN 216',	'188/2649/KPTS/022.3/2021',	'2021-07-02');

DROP TABLE IF EXISTS "sumber_dana";
CREATE TABLE "public"."sumber_dana" (
    "id" integer NOT NULL,
    "nama_sumber_dana" character varying(255) NOT NULL,
    CONSTRAINT "sumber_dana_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "sumber_dana" ("id", "nama_sumber_dana") VALUES
(1,	'APBD'),
(2,	'APBN'),
(3,	'BLUD'),
(4,	'LAINNYA');

ALTER TABLE ONLY "public"."data_training" ADD CONSTRAINT "fk_1fcc43531fa76ec4" FOREIGN KEY (pokja_id) REFERENCES pokja(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."data_training" ADD CONSTRAINT "fk_1fcc4353343b9189" FOREIGN KEY (jenis_pengadaan_id) REFERENCES jenis_pengadaan(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."data_training" ADD CONSTRAINT "fk_1fcc43535c5f347b" FOREIGN KEY (pagu_id) REFERENCES pagu(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."data_training" ADD CONSTRAINT "fk_1fcc4353bb7f56bd" FOREIGN KEY (sumber_dana_id) REFERENCES sumber_dana(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."data_training" ADD CONSTRAINT "fk_1fcc4353c6469e3b" FOREIGN KEY (jenis_kontrak_id) REFERENCES jenis_kontrak(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."kmj_default_user" ADD CONSTRAINT "fk_f2b64656bf396750" FOREIGN KEY (id) REFERENCES kmj_user(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."my_user" ADD CONSTRAINT "fk_4db4ff1dbf396750" FOREIGN KEY (id) REFERENCES kmj_user(id) ON DELETE CASCADE NOT DEFERRABLE;

-- 2022-07-21 12:31:49.889596+07
