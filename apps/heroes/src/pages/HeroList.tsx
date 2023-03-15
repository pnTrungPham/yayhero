import HeroAttribute from "@src/components/HeroAttribute";
import useMutationHeroDelete from "@src/hooks/useMutationHeroDelete";
import useQueryHeroes from "@src/hooks/useQueryHeroes";
import {
  HeroAttributes,
  HeroModel,
  HERO_CLASSES,
} from "@src/types/heroes.type";
import { getErrorMessage } from "@src/utils/common";
import { notifySuccess } from "@src/utils/notification";
import { Button, Popconfirm, Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import { CSSProperties } from "react";
import { Link, useNavigate } from "react-router-dom";
import { useQueryClient } from "react-query";

function HeroList() {
  const navigate = useNavigate();

  const { isLoading, data: heroesData } = useQueryHeroes();

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

  const columns: ColumnsType<HeroModel> = [
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
      defaultSortOrder: "descend",
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
      render: (value: number) => <span className="level-badge">{value}</span>,
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

  const getRowStyle = (): CSSProperties => {
    return {
      cursor: "pointer",
    };
  };

  const handleOnRowClick = (record: HeroModel) => {
    queryClient.setQueryData(["hero", record.id], record);
    navigate(`/heroes/edit/${record.id}`);
  };

  return (
    <div>
      <header className="yayhero-herolist-title">
        <h4>Heroes</h4>
        <Link to="/heroes/add">
          <Button type="primary">Add Heroes</Button>
        </Link>
      </header>

      <Table
        loading={isLoading || isDeleting}
        rowKey={(record) => record.id}
        columns={columns}
        dataSource={heroesData}
        onRow={(record) => {
          return {
            onClick: () => handleOnRowClick(record),
            style: getRowStyle(),
          };
        }}
        rowSelection={{
          type: "checkbox",
        }}
        pagination={{
          defaultPageSize: 10,
          showSizeChanger: true,
          pageSizeOptions: ["10", "20", "30"],
        }}
      />
    </div>
  );
}

export default HeroList;
