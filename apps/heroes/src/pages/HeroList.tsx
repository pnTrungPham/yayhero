import { PageOptions } from "@src/api/heroEndpoint";
import HeroAttribute from "@src/components/HeroAttribute";
import HeroLevelCell from "@src/components/HeroLevelCell";
import useMutationHeroDelete from "@src/hooks/useMutationHeroDelete";
import useQueryHeroes from "@src/hooks/useQueryHeroes";
import { yayHeroData } from "@src/localize";
import {
  HeroAttributes,
  HeroModel,
  HERO_CLASSES,
} from "@src/types/heroes.type";
import { getErrorMessage } from "@src/utils/common";
import { notifySuccess } from "@src/utils/notification";
import { Button, Pagination, Popconfirm, Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import { CSSProperties, useState } from "react";
import { useQueryClient } from "react-query";
import { Link, useNavigate } from "react-router-dom";

function HeroList() {
  const navigate = useNavigate();

  const [pagingOptions, setPagingOptions] = useState<PageOptions>({
    page: 1,
    size: 5,
  });

  const { isLoading, data: heroesData } = useQueryHeroes(pagingOptions);

  const { isLoading: isDeleting, mutateAsync: deleteAsync } =
    useMutationHeroDelete();

  const queryClient = useQueryClient();

  const onHeroDelete = async (id: number) => {
    try {
      await deleteAsync(id);
      notifySuccess({
        message: "Success",
        description: "Hero deleted!",
      });
    } catch (e) {
      const msg = await getErrorMessage(e);

      notifySuccess({
        message: "Error",
        description: msg,
      });
    }
  };

  const handlePaginationChange = (page: number, pageSize: number) => {
    setPagingOptions({ page, size: pageSize });
  };

  let columns: ColumnsType<HeroModel> = [
    {
      title: "ID",
      dataIndex: "id",
      key: "id",
      render: (value: string) => <span>{value}</span>,
    },
    {
      title: "Name",
      dataIndex: "name",
      key: "name",
      render: (value: string) => <span>{value}</span>,
      sorter: (a, b) => a.name.localeCompare(b.name),
    },
    {
      title: "Class",
      dataIndex: "class",
      key: "class",
      render: (value: string) => <span>{value}</span>,
      filters: HERO_CLASSES.map((hero) => {
        return { text: hero, value: hero };
      }),
      onFilter: (value: string | number | boolean, record) =>
        record.class === value,
      filterMode: "tree",
    },
    {
      title: "Level",
      dataIndex: "level",
      key: "level",
      render: (value: number, record) => (
        <HeroLevelCell level={value} id={record.id} />
      ),
    },
    {
      title: "Attributes",
      dataIndex: "attributes",
      key: "attributes",
      render: (attributes: HeroAttributes) => (
        <HeroAttribute attributes={attributes} />
      ),
    },
    {
      title: "Action",
      key: "action",
      render: (_, record) => (
        <Popconfirm
          title="Delete the hero"
          description="Are you sure to delete this hero?"
          okText="Yes"
          cancelText="No"
          okButtonProps={{ type: "primary" }}
          okType="danger"
          onConfirm={(e) => {
            e?.stopPropagation();
            onHeroDelete(record.id);
          }}
          onCancel={(e) => {
            e?.stopPropagation();
          }}
        >
          <Button
            type="primary"
            danger
            onClick={(event) => {
              event.stopPropagation();
            }}
          >
            Delete
          </Button>
        </Popconfirm>
      ),
    },
  ];

  if (!yayHeroData.auth.canWrite) {
    columns = columns.filter((col) => col.key !== "action");
  }

  const getRowStyle = (): CSSProperties => {
    return {
      cursor: "pointer",
    };
  };

  const handleOnRowClick = async (record: HeroModel) => {
    queryClient.setQueryData(["hero", record.id], record);
    queryClient.invalidateQueries(["hero", record.id]);

    navigate(`/heroes/edit/${record.id}`);
  };

  return (
    <div>
      <header className="yayhero-herolist-title">
        <h4>Heroes</h4>
        {yayHeroData.auth.canWrite && (
          <Link to="/heroes/add">
            <Button type="primary">Add Heroes</Button>
          </Link>
        )}
      </header>

      <Table
        loading={isLoading || isDeleting}
        rowKey={(record) => record.id}
        columns={columns}
        dataSource={heroesData?.content}
        onRow={(record) => {
          return {
            onClick: () => handleOnRowClick(record),
            style: getRowStyle(),
          };
        }}
        rowSelection={{
          type: "checkbox",
        }}
        pagination={false}
      />

      <Pagination
        defaultCurrent={1}
        current={pagingOptions.page}
        defaultPageSize={pagingOptions.size}
        pageSize={pagingOptions.size}
        pageSizeOptions={[5, 10]}
        total={heroesData?.totalItems}
        showSizeChanger={true}
        onChange={handlePaginationChange}
      />
    </div>
  );
}

export default HeroList;
